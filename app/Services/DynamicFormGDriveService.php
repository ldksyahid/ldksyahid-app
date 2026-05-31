<?php

namespace App\Services;

use App\Models\forms\MsForm;
use App\Models\forms\MsFormField;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Google_Service_Sheets;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_SpreadsheetProperties;
use Google_Service_Sheets_ValueRange;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class DynamicFormGDriveService
{
    // Root GDrive folder that contains all dynamic form folders
    // Set via env: GDRIVE_DYNAMIC_FORM_ROOT_FOLDER_ID
    private string $rootFolderID;

    private Google_Client         $client;
    private Google_Service_Drive  $driveService;
    private Google_Service_Sheets $sheetsService;

    public function __construct()
    {
        $this->rootFolderID = env('GDRIVE_DYNAMIC_FORM_ROOT_FOLDER_ID', '');

        if (empty($this->rootFolderID)) {
            throw new RuntimeException('GDRIVE_DYNAMIC_FORM_ROOT_FOLDER_ID is not configured.');
        }

        $this->client = $this->buildClient();
        $this->driveService  = new Google_Service_Drive($this->client);
        $this->sheetsService = new Google_Service_Sheets($this->client);
    }

    // -------------------------------------------------------------------------
    // Client bootstrap — reuse existing GDrive credentials
    // -------------------------------------------------------------------------

    private function buildClient(): Google_Client
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));

        // Scopes required: Drive (file management) + Sheets (spreadsheet write)
        $client->setScopes([
            Google_Service_Drive::DRIVE,
            Google_Service_Sheets::SPREADSHEETS,
        ]);

        return $client;
    }

    // =========================================================================
    // STEP 1 — setupFormFolder()
    // Called once when admin creates a new form.
    // Returns an array of GDrive IDs to be saved into ms_form.
    // =========================================================================

    /**
     * Create the complete GDrive folder structure for a form:
     *
     *   dynamic_form/
     *   └── {Form Title}/               ← form folder
     *       ├── {Form Title} Responses  ← Google Spreadsheet
     *       ├── attachments/            ← file upload folder (field type: file)
     *       │   └── {file_field_label}/
     *       └── assets/                 ← image upload folder (field type: image)
     *           └── {image_field_label}/
     *
     * Also grants Editor access to:
     *   - The admin who created the form (creatorEmail)
     *   - Any additional collaborator emails
     *
     * @param  string   $formTitle        Title of the form (used as folder name)
     * @param  string   $creatorEmail     Email of the admin who created the form
     * @param  array    $collaborators    Additional collaborator emails
     * @param  array    $fileFieldLabels  Labels of file fields → subfolders in attachments/
     * @param  array    $imageFieldLabels Labels of image fields → subfolders in assets/
     * @return array    {
     *     gdriveFolderID,
     *     gdriveSpreadsheetID,
     *     gdriveSpreadsheetUrl,
     *     gdriveAttachmentsFolderID,
     *     gdriveAttachmentsFolderUrl,
     *     gdriveAssetsFolderID,
     *     gdriveAssetsFolderUrl,
     *     fieldFolders: [{label, gdriveFolderID, gdriveAttachmentsFolderUrl}, ...]
     * }
     */
    public function setupFormFolder(
        string $formTitle,
        string $creatorEmail,
        array  $collaborators    = [],
        array  $fileFieldLabels  = [],
        array  $spreadsheetHeaders = [],
        array  $imageFieldLabels = []
    ): array {
        // 0. Restrict the root folder first.
        //    The root folder's anyoneWithLink permission propagates to every child
        //    created inside it. Child items inherit it from the root, so trying to
        //    delete it on the child returns 404 (no direct permission found).
        //    Removing it from the root stops the inheritance at the source.
        $this->restrictAccess($this->rootFolderID);

        // 1. Create the form folder inside the root dynamic_form folder
        $formFolderID = $this->createFolder($formTitle, $this->rootFolderID);
        $this->restrictAccess($formFolderID);

        // 2. Create the Google Spreadsheet inside the form folder
        $spreadsheet = $this->createSpreadsheet(
            $formTitle . ' Responses',
            $formFolderID,
            $spreadsheetHeaders
        );
        $this->restrictAccess($spreadsheet['id']);

        // 3. Create the attachments folder (for file fields)
        $attachmentsFolderID  = $this->createFolder('attachments', $formFolderID);
        $this->restrictAccess($attachmentsFolderID);
        $attachmentsFolderUrl = "https://drive.google.com/drive/folders/{$attachmentsFolderID}";

        // 4. Create the assets folder (for image fields)
        $assetsFolderID  = $this->createFolder('assets', $formFolderID);
        $this->restrictAccess($assetsFolderID);
        $assetsFolderUrl = "https://drive.google.com/drive/folders/{$assetsFolderID}";

        // 5. Create per-field subfolders inside attachments/ (for file fields)
        $fieldFolders = [];
        foreach ($fileFieldLabels as $label) {
            $subFolderID  = $this->createFolder($label, $attachmentsFolderID);
            $this->restrictAccess($subFolderID);
            $subFolderUrl = "https://drive.google.com/drive/folders/{$subFolderID}";

            $fieldFolders[] = [
                'label'                      => $label,
                'gdriveFolderID'             => $subFolderID,
                'gdriveAttachmentsFolderUrl' => $subFolderUrl,
            ];
        }

        // 6. Create per-field subfolders inside assets/ (for image fields)
        foreach ($imageFieldLabels as $label) {
            $subFolderID  = $this->createFolder($label, $assetsFolderID);
            $this->restrictAccess($subFolderID);
            $subFolderUrl = "https://drive.google.com/drive/folders/{$subFolderID}";

            $fieldFolders[] = [
                'label'                      => $label,
                'gdriveFolderID'             => $subFolderID,
                'gdriveAttachmentsFolderUrl' => $subFolderUrl,
            ];
        }

        // 7. Grant Editor (writer) access to: creator + collaborators
        $editorEmails = array_unique(array_filter(array_merge([$creatorEmail], $collaborators)));
        foreach ($editorEmails as $email) {
            $this->grantEditorAccess($formFolderID, $email);
        }

        return [
            'gdriveFolderID'             => $formFolderID,
            'gdriveSpreadsheetID'        => $spreadsheet['id'],
            'gdriveSpreadsheetUrl'       => $spreadsheet['url'],
            'gdriveAttachmentsFolderID'  => $attachmentsFolderID,
            'gdriveAttachmentsFolderUrl' => $attachmentsFolderUrl,
            'gdriveAssetsFolderID'       => $assetsFolderID,
            'gdriveAssetsFolderUrl'      => $assetsFolderUrl,
            'fieldFolders'               => $fieldFolders,
        ];
    }

    // =========================================================================
    // STEP 2 — appendSubmissionToSheet()
    // Called on every form submission to write a new row to the spreadsheet.
    // =========================================================================

    /**
     * Append a row of answers to the Google Spreadsheet.
     * Returns the 1-based row index of the newly added row.
     *
     * @param  string $spreadsheetID  The GDrive Spreadsheet ID
     * @param  array  $rowData        Ordered array of answer values (matching header columns)
     * @return int                    Row index of the appended row (1-based)
     */
    public function appendSubmissionToSheet(string $spreadsheetID, array $rowData): int
    {
        $range    = 'Sheet1!A:A';
        $valueRow = [array_values($rowData)];

        $body = new Google_Service_Sheets_ValueRange(['values' => $valueRow]);

        $params = [
            'valueInputOption'       => 'USER_ENTERED',
            'insertDataOption'       => 'INSERT_ROWS',
            'includeValuesInResponse' => false,
        ];

        $response = $this->sheetsService->spreadsheets_values->append(
            $spreadsheetID,
            $range,
            $body,
            $params
        );

        // Parse the updatedRange to extract the actual row number
        // updatedRange looks like: "Sheet1!A5:F5" → row 5
        $updatedRange = $response->getUpdates()
                                 ? $response->getUpdates()->getUpdatedRange()
                                 : '';

        preg_match('/(\d+)$/', $updatedRange ?? '', $matches);

        return (int) ($matches[1] ?? 0);
    }

    // =========================================================================
    // STEP 3 — uploadFileToFieldFolder()
    // Called for each file/image uploaded in a submission.
    // =========================================================================

    /**
     * Upload a file to the GDrive subfolder that belongs to a specific form field.
     * The filename is prefixed with the submission ID to prevent collisions.
     *
     * @param  string       $gdriveFolderID  Target folder ID (the per-field subfolder)
     * @param  UploadedFile $file            The uploaded file from the request
     * @param  int          $submissionID    Used as filename prefix
     * @return array        {gdriveFileID, gdriveFileUrl, originalFileName, mimeType, fileSizeKB}
     */
    public function uploadFileToFieldFolder(
        string       $gdriveFolderID,
        UploadedFile $file,
        int          $submissionID
    ): array {
        $originalName = $file->getClientOriginalName();
        $storedName   = "submission_{$submissionID}_{$originalName}";
        $mimeType     = $file->getMimeType() ?? 'application/octet-stream';
        $fileSizeKB   = (int) ceil($file->getSize() / 1024);

        $driveFile = new Google_Service_Drive_DriveFile([
            'name'    => $storedName,
            'parents' => [$gdriveFolderID],
        ]);

        $content = file_get_contents($file->getRealPath());

        $uploaded = $this->driveService->files->create(
            $driveFile,
            [
                'data'       => $content,
                'mimeType'   => $mimeType,
                'uploadType' => 'multipart',
                'fields'     => 'id,name',
            ]
        );

        $fileID  = $uploaded->getId();
        $fileUrl = "https://drive.google.com/file/d/{$fileID}/view";

        return [
            'gdriveFileID'    => $fileID,
            'gdriveFileUrl'   => $fileUrl,
            'originalFileName' => $originalName,
            'mimeType'        => $mimeType,
            'fileSizeKB'      => $fileSizeKB,
        ];
    }

    // =========================================================================
    // Update spreadsheet cell (used to replace file placeholder with GDrive link)
    // =========================================================================

    /**
     * Update a single cell in the spreadsheet.
     * Used to replace the placeholder value in a file-upload column with a GDrive link
     * after the file has been uploaded.
     *
     * @param  string $spreadsheetID  Target spreadsheet
     * @param  int    $rowIndex       1-based row number
     * @param  int    $colIndex       0-based column index
     * @param  string $value          New cell value
     */
    public function updateCell(string $spreadsheetID, int $rowIndex, int $colIndex, string $value): void
    {
        // Convert column index to A1 notation (0=A, 1=B, 2=C, ...)
        $colLetter = chr(65 + $colIndex);
        $range     = "Sheet1!{$colLetter}{$rowIndex}";

        $body = new Google_Service_Sheets_ValueRange([
            'values' => [[$value]],
        ]);

        $this->sheetsService->spreadsheets_values->update(
            $spreadsheetID,
            $range,
            $body,
            ['valueInputOption' => 'USER_ENTERED']
        );
    }

    // =========================================================================
    // Permission management
    // =========================================================================

    /**
     * Grant Editor (writer) access to a GDrive folder for a given email address.
     * Permission is applied to the folder — applies to all contents automatically.
     */
    public function grantEditorAccess(string $folderID, string $email): void
    {
        try {
            $permission = new Google_Service_Drive_Permission([
                'type'         => 'user',
                'role'         => 'writer',
                'emailAddress' => $email,
            ]);

            $this->driveService->permissions->create(
                $folderID,
                $permission,
                ['sendNotificationEmail' => false]
            );
        } catch (\Exception $e) {
            // Non-fatal: log and continue. A bad email should not stop form creation.
            Log::error("[DynamicFormGDriveService] Failed to grant access to {$email}: " . $e->getMessage());
        }
    }

    /**
     * Remove public "anyone with the link" access from a file or folder.
     *
     * In Google Drive API v3, the "anyone with the link" permission always has
     * the fixed ID 'anyoneWithLink'. We delete it directly instead of listing
     * all permissions first — listPermissions does not reliably return inherited
     * permissions propagated from ancestor folders, so the list-then-delete
     * approach silently misses them.
     *
     * A 404 response means the permission was never set (file is already private),
     * which is the desired outcome and not treated as an error.
     * Non-fatal: logs warning but does not throw.
     */
    private function restrictAccess(string $fileID): void
    {
        try {
            $this->driveService->permissions->delete($fileID, 'anyoneWithLink');
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            // 404 = permission not found (file already private) — expected, not an error
            if (strpos($msg, '404') === false && strpos($msg, 'fileNotFound') === false) {
                Log::error("[DynamicFormGDriveService] Could not restrict access on {$fileID}: {$msg}");
            }
        }
    }

    /**
     * Permanently delete the form's root GDrive folder and all its contents
     * (spreadsheet + attachments folder + all uploaded files).
     * Non-fatal: logs error but does not throw.
     */
    public function deleteFormFolder(string $folderID): void
    {
        try {
            $this->driveService->files->delete($folderID);
        } catch (\Exception $e) {
            Log::error("[DynamicFormGDriveService] Failed to delete folder {$folderID}: " . $e->getMessage());
        }
    }

    /**
     * Revoke a specific user's access to a folder by listing and deleting their permission.
     */
    public function revokeAccess(string $folderID, string $email): void
    {
        try {
            $permissions = $this->driveService->permissions->listPermissions(
                $folderID,
                ['fields' => 'permissions(id,emailAddress)']
            );

            foreach ($permissions->getPermissions() as $perm) {
                if (strtolower($perm->getEmailAddress()) === strtolower($email)) {
                    $this->driveService->permissions->delete($folderID, $perm->getId());
                    break;
                }
            }
        } catch (\Exception $e) {
            Log::error("[DynamicFormGDriveService] Failed to revoke access for {$email}: " . $e->getMessage());
        }
    }

    // =========================================================================
    // Private helpers
    // =========================================================================

    /**
     * Create a folder inside a given parent folder and return its ID.
     */
    private function createFolder(string $name, string $parentFolderID): string
    {
        $metadata = new Google_Service_Drive_DriveFile([
            'name'     => $name,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents'  => [$parentFolderID],
        ]);

        $folder = $this->driveService->files->create($metadata, ['fields' => 'id']);

        return $folder->getId();
    }

    /**
     * Create a Google Spreadsheet inside a given folder.
     * Writes the header row immediately so the sheet is ready for submissions.
     *
     * @return array {id, url}
     */
    private function createSpreadsheet(string $title, string $parentFolderID, array $headers): array
    {
        // Create the spreadsheet file
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name'     => $title,
            'mimeType' => 'application/vnd.google-apps.spreadsheet',
            'parents'  => [$parentFolderID],
        ]);

        $file = $this->driveService->files->create($fileMetadata, ['fields' => 'id']);
        $spreadsheetID = $file->getId();

        // Write the header row if headers are provided
        if (!empty($headers)) {
            $headerRow = new Google_Service_Sheets_ValueRange([
                'values' => [array_values($headers)],
            ]);

            $this->sheetsService->spreadsheets_values->update(
                $spreadsheetID,
                'Sheet1!A1',
                $headerRow,
                ['valueInputOption' => 'RAW']
            );

            $this->autoResizeColumns($spreadsheetID, count($headers));
        }

        return [
            'id'  => $spreadsheetID,
            'url' => "https://docs.google.com/spreadsheets/d/{$spreadsheetID}/edit",
        ];
    }

    // =========================================================================
    // Update spreadsheet headers — overwrites row 1 with the current field list
    // =========================================================================

    /**
     * Overwrite the header row (row 1) of an existing spreadsheet.
     * Called by the Form Builder whenever a field is added.
     *
     * @param  string $spreadsheetID  The GDrive Spreadsheet ID
     * @param  array  $headers        Ordered list of header strings
     */
    public function updateSpreadsheetHeaders(string $spreadsheetID, array $headers): void
    {
        if (empty($headers)) {
            return;
        }

        // Clear entire row 1 first so removed columns do not linger
        $this->sheetsService->spreadsheets_values->clear(
            $spreadsheetID,
            'Sheet1!1:1',
            new \Google_Service_Sheets_ClearValuesRequest()
        );

        $body = new Google_Service_Sheets_ValueRange([
            'values' => [array_values($headers)],
        ]);

        $this->sheetsService->spreadsheets_values->update(
            $spreadsheetID,
            'Sheet1!A1',
            $body,
            ['valueInputOption' => 'RAW']
        );

        $this->autoResizeColumns($spreadsheetID, count($headers));
    }

    // =========================================================================
    // Rename a folder (used when a file/image field label is updated)
    // =========================================================================

    /**
     * Rename an existing GDrive folder.
     * Called when a file/image field's label is updated in the form builder.
     */
    public function renameFolder(string $folderID, string $newName): void
    {
        $metadata = new Google_Service_Drive_DriveFile(['name' => $newName]);
        $this->driveService->files->update($folderID, $metadata);
    }

    // =========================================================================
    // Create a single per-field subfolder inside an existing attachments folder
    // =========================================================================

    /**
     * Create one subfolder inside the form's existing attachments folder.
     * Called when a file/image field is added to an already-configured form.
     * Does NOT create a new root folder, spreadsheet, or attachments folder.
     *
     * @param  string $attachmentsFolderID  ID of the form's existing attachments/ folder
     * @param  string $fieldLabel           Used as the subfolder name
     * @return array  {gdriveFolderID, gdriveAttachmentsFolderUrl}
     */
    public function createFieldAttachmentFolder(string $attachmentsFolderID, string $fieldLabel): array
    {
        $subFolderID  = $this->createFolder($fieldLabel, $attachmentsFolderID);
        $this->restrictAccess($subFolderID);
        $subFolderUrl = "https://drive.google.com/drive/folders/{$subFolderID}";

        return [
            'gdriveFolderID'             => $subFolderID,
            'gdriveAttachmentsFolderUrl' => $subFolderUrl,
        ];
    }

    /**
     * Create the assets/ folder inside an existing form folder.
     * Called lazily when an image display field is added to a form that was
     * created before the assets folder feature was introduced.
     *
     * @param  string $formFolderID  ID of the form's root GDrive folder
     * @return array  {gdriveAssetsFolderID, gdriveAssetsFolderUrl}
     */
    public function createAssetsFolder(string $formFolderID): array
    {
        $folderID  = $this->createFolder('assets', $formFolderID);
        $this->restrictAccess($folderID);
        $folderUrl = "https://drive.google.com/drive/folders/{$folderID}";

        return [
            'gdriveAssetsFolderID'  => $folderID,
            'gdriveAssetsFolderUrl' => $folderUrl,
        ];
    }

    /**
     * Upload an image file to the form's assets/ folder for display embedding.
     * The file is granted public read access so <img src="..."> works in the browser.
     *
     * @param  string       $assetsFolderID  ID of the form's assets/ folder
     * @param  UploadedFile $file            The uploaded image file
     * @param  string       $fieldLabel      Used as filename prefix
     * @return array        {gdriveFileID, publicUrl}
     */
    public function uploadImageToAssetsFolder(
        string       $assetsFolderID,
        UploadedFile $file,
        string       $fieldLabel
    ): array {
        $originalName = $file->getClientOriginalName();
        $storedName   = $fieldLabel . '_' . time() . '_' . $originalName;
        $mimeType     = $file->getMimeType() ?? 'image/jpeg';

        $driveFile = new Google_Service_Drive_DriveFile([
            'name'    => $storedName,
            'parents' => [$assetsFolderID],
        ]);

        $content = file_get_contents($file->getRealPath());

        $uploaded = $this->driveService->files->create(
            $driveFile,
            [
                'data'       => $content,
                'mimeType'   => $mimeType,
                'uploadType' => 'multipart',
                'fields'     => 'id,name',
            ]
        );

        $fileID = $uploaded->getId();

        // Grant public read access so the image can be embedded via <img src="...">
        $permission = new Google_Service_Drive_Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]);
        $this->driveService->permissions->create($fileID, $permission);

        return [
            'gdriveFileID' => $fileID,
            'publicUrl'    => "https://lh3.googleusercontent.com/d/{$fileID}",
        ];
    }

    /**
     * @deprecated image type is now a display field, no subfolder needed.
     */
    public function createFieldAssetsFolder(string $assetsFolderID, string $fieldLabel): array
    {
        $subFolderID  = $this->createFolder($fieldLabel, $assetsFolderID);
        $this->restrictAccess($subFolderID);
        $subFolderUrl = "https://drive.google.com/drive/folders/{$subFolderID}";

        return [
            'gdriveFolderID'             => $subFolderID,
            'gdriveAttachmentsFolderUrl' => $subFolderUrl,
        ];
    }

    // =========================================================================
    // Reorder spreadsheet columns — rearranges ALL rows to match new field order
    // =========================================================================

    /**
     * Reorder ALL columns in the spreadsheet (headers + every data row)
     * to match the new field order after a drag-and-drop reorder in the builder.
     *
     * Algorithm:
     *  1. Read the full sheet (all rows).
     *  2. Build a mapping: new column index → old column index (by matching header labels).
     *  3. Clear the sheet.
     *  4. Write all rows back with columns in the new order.
     *
     * @param  string $spreadsheetID     Target spreadsheet
     * @param  array  $newOrderedHeaders Desired header order (output of buildSpreadsheetHeaders)
     */
    public function reorderSpreadsheetColumns(string $spreadsheetID, array $newOrderedHeaders): void
    {
        if (empty($newOrderedHeaders)) {
            return;
        }

        // 1. Read entire sheet
        $response = $this->sheetsService->spreadsheets_values->get($spreadsheetID, 'Sheet1');
        $rows     = $response->getValues() ?? [];

        if (empty($rows)) {
            // Sheet is empty — just write the new header row
            $this->updateSpreadsheetHeaders($spreadsheetID, $newOrderedHeaders);
            return;
        }

        $currentHeaders = $rows[0];

        // 2. Build column map: new index → old index (null = column doesn't exist yet)
        $columnMap = [];
        foreach ($newOrderedHeaders as $newIdx => $header) {
            $oldIdx = array_search($header, $currentHeaders, true);
            $columnMap[$newIdx] = ($oldIdx !== false) ? (int) $oldIdx : null;
        }

        // 3. Reorder every row according to the map
        $reorderedRows = [];
        foreach ($rows as $row) {
            $newRow = [];
            foreach ($columnMap as $oldIdx) {
                $newRow[] = ($oldIdx !== null) ? ($row[$oldIdx] ?? '') : '';
            }
            $reorderedRows[] = $newRow;
        }

        // 4. Clear the entire sheet and write reordered data back
        $this->sheetsService->spreadsheets_values->clear(
            $spreadsheetID,
            'Sheet1',
            new \Google_Service_Sheets_ClearValuesRequest()
        );

        $body = new Google_Service_Sheets_ValueRange(['values' => $reorderedRows]);
        $this->sheetsService->spreadsheets_values->update(
            $spreadsheetID,
            'Sheet1!A1',
            $body,
            ['valueInputOption' => 'RAW']
        );

        $this->autoResizeColumns($spreadsheetID, count($newOrderedHeaders));
    }

    // =========================================================================
    // Auto-resize spreadsheet columns to fit content
    // =========================================================================

    /**
     * Auto-resize all columns in Sheet1 to fit their content.
     * Uses the Sheets batchUpdate AutoResizeDimensionsRequest.
     * Non-fatal: logs warning on failure.
     */
    private function autoResizeColumns(string $spreadsheetID, int $columnCount): void
    {
        if ($columnCount <= 0) {
            return;
        }

        try {
            $request = new \Google_Service_Sheets_Request([
                'autoResizeDimensions' => [
                    'dimensions' => [
                        'sheetId'    => 0,
                        'dimension'  => 'COLUMNS',
                        'startIndex' => 0,
                        'endIndex'   => $columnCount,
                    ],
                ],
            ]);

            $batchBody = new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
                'requests' => [$request],
            ]);

            $this->sheetsService->spreadsheets->batchUpdate($spreadsheetID, $batchBody);
        } catch (\Throwable $e) {
            Log::error('[DynamicFormGDriveService] autoResizeColumns failed: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // Header builder — converts form fields into spreadsheet column headers
    // =========================================================================

    /**
     * Build the spreadsheet header row from the active fields of a form.
     * System columns (Timestamp, Submission ID) are prepended automatically.
     *
     * @param  array $fields  Collection of MsFormField objects
     * @return array          Ordered list of header strings
     */
    public static function buildSpreadsheetHeaders(array $fields): array
    {
        $headers = ['Timestamp', 'Submission ID'];

        foreach ($fields as $field) {
            // Skip display-only fields (section_break, paragraph)
            if (in_array($field->fieldType, MsFormField::TYPE_DISPLAY_FIELDS)) {
                continue;
            }
            $headers[] = $field->label;
        }

        return $headers;
    }
}
