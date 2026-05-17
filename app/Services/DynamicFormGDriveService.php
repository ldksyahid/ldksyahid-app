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
     *       └── attachments/            ← file upload folder
     *           ├── {field_label_1}/    ← per-field subfolder (for each file/image field)
     *           └── {field_label_2}/
     *
     * Also grants Editor access to:
     *   - The admin who created the form (creatorEmail)
     *   - Any additional collaborator emails
     *
     * @param  string   $formTitle       Title of the form (used as folder name)
     * @param  string   $creatorEmail    Email of the admin who created the form
     * @param  array    $collaborators   Additional collaborator emails
     * @param  array    $fileFieldLabels Labels of file/image fields (used for subfolder names)
     * @return array    {
     *     gdriveFolderID,
     *     gdriveSpreadsheetID,
     *     gdriveSpreadsheetUrl,
     *     gdriveAttachmentsFolderID,
     *     gdriveAttachmentsFolderUrl,
     *     fieldFolders: [{label, gdriveFolderID, gdriveAttachmentsFolderUrl}, ...]
     * }
     */
    public function setupFormFolder(
        string $formTitle,
        string $creatorEmail,
        array  $collaborators   = [],
        array  $fileFieldLabels = [],
        array  $spreadsheetHeaders = []
    ): array {
        // 1. Create the form folder inside the root dynamic_form folder
        $formFolderID = $this->createFolder($formTitle, $this->rootFolderID);

        // 2. Create the Google Spreadsheet inside the form folder
        $spreadsheet = $this->createSpreadsheet(
            $formTitle . ' Responses',
            $formFolderID,
            $spreadsheetHeaders
        );

        // 3. Create the attachments folder
        $attachmentsFolderID  = $this->createFolder('attachments', $formFolderID);
        $attachmentsFolderUrl = "https://drive.google.com/drive/folders/{$attachmentsFolderID}";

        // 4. Create per-field subfolders inside attachments/
        $fieldFolders = [];
        foreach ($fileFieldLabels as $label) {
            $subFolderID  = $this->createFolder($label, $attachmentsFolderID);
            $subFolderUrl = "https://drive.google.com/drive/folders/{$subFolderID}";

            $fieldFolders[] = [
                'label'                     => $label,
                'gdriveFolderID'            => $subFolderID,
                'gdriveAttachmentsFolderUrl' => $subFolderUrl,
            ];
        }

        // 5. Grant Editor (writer) access to: creator + collaborators
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
            Log::warning("[DynamicFormGDriveService] Failed to grant access to {$email}: " . $e->getMessage());
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
            Log::warning("[DynamicFormGDriveService] Failed to revoke access for {$email}: " . $e->getMessage());
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
        }

        return [
            'id'  => $spreadsheetID,
            'url' => "https://docs.google.com/spreadsheets/d/{$spreadsheetID}/edit",
        ];
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
