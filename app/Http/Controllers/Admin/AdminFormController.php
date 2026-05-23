<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\forms\MsForm;
use App\Models\forms\MsFormField;
use App\Models\forms\MsFormSection;
use App\Models\forms\MsFormSetting;
use App\Models\forms\TrFormAuditLog;
use App\Services\DynamicFormGDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class AdminFormController extends Controller
{
    // -------------------------------------------------------------------------
    // Index
    // -------------------------------------------------------------------------

    /**
     * Display a paginated list of forms (admin).
     * Supports AJAX for filtering without page reload.
     */
    public function index(Request $request)
    {
        $items       = MsForm::searchAdminForms($request);
        $tableConfig = MsForm::getTableConfig();

        if ($request->ajax()) {
            return response()->json([
                'tableBody'  => view('components.admin-index.index-table', compact('items', 'tableConfig'))->render(),
                'pagination' => $items->appends($request->query())->links()->render(),
                'total'      => $items->total(),
                'from'       => $items->firstItem(),
                'to'         => $items->lastItem(),
            ]);
        }

        return view('admin-page.forms.index', compact('items', 'tableConfig'))
            ->with('title', 'Dynamic Forms');
    }

    // -------------------------------------------------------------------------
    // Create / Store
    // -------------------------------------------------------------------------

    public function create()
    {
        return view('admin-page.forms.create')
            ->with('title', 'Create New Form');
    }

    /**
     * Store a newly created form.
     *
     * Steps:
     * 1. Validate request
     * 2. Create ms_form record
     * 3. Auto-insert system email field
     * 4. Seed default settings
     * 5. Setup GDrive folder structure
     * 6. Save GDrive IDs back to ms_form
     * 7. Record audit log
     */
    public function store(Request $request)
    {
        // Prevent duplicate submission within 15 seconds
        $lockKey = 'form_store_lock_' . auth()->id();
        if (Cache::has($lockKey)) {
            Alert::warning('Please Wait', 'Your form is being processed, please wait a moment.');
            return redirect()->route('admin.forms.index');
        }
        Cache::put($lockKey, true, 15);

        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'description'         => 'nullable|string|max:2000',
            'maxSubmission'       => 'nullable|integer|min:1',
            'startDate'           => 'nullable|date',
            'endDate'             => 'nullable|date|after_or_equal:startDate',
            'confirmationMessage' => 'nullable|string|max:1000',
            'redirectUrl'         => 'nullable|url|max:500',
            'collaboratorEmails'  => 'nullable|string',
        ]);

        try {
            $now  = Carbon::now();
            $user = auth()->user();

            // Parse comma-separated collaborator emails into array
            $collaboratorEmails = self::parseEmailList($validated['collaboratorEmails'] ?? '');

            // 1. Create the form record
            $form = MsForm::create([
                'title'               => $validated['title'],
                'slug'                => MsForm::generateSlug($validated['title']),
                'description'         => $validated['description']         ?? null,
                'status'              => 'draft',
                'version'             => 1,
                'maxSubmission'       => $validated['maxSubmission']       ?? null,
                'isMultipleSubmit'    => false,
                'requireLogin'        => false,
                'startDate'           => $validated['startDate']           ?? null,
                'endDate'             => $validated['endDate']             ?? null,
                'confirmationMessage' => $validated['confirmationMessage'] ?? null,
                'redirectUrl'         => $validated['redirectUrl']         ?? null,
                'notifyEmails'        => [],
                'collaboratorEmails'  => $collaboratorEmails,
                'totalSubmission'     => 0,
                'flagActive'          => true,
                'createdBy'           => $user->name,
                'createdDate'         => $now,
            ]);

            // 2. Auto-insert the mandatory system email field
            MsFormField::createSystemEmailField($form->formID);

            // 3. Seed default per-form settings
            MsFormSetting::seedDefaults($form->formID);

            // 4. Setup GDrive folder structure
            //    Headers at creation time: only the system email field exists,
            //    more will be added via the form builder. We pass an empty list here
            //    and let the builder handle per-field subfolder creation later.
            $gdriveService = new DynamicFormGDriveService();
            $gdriveResult  = $gdriveService->setupFormFolder(
                formTitle:          $form->title,
                creatorEmail:       $user->email,
                collaborators:      $collaboratorEmails,
                fileFieldLabels:    [],
                spreadsheetHeaders: DynamicFormGDriveService::buildSpreadsheetHeaders(
                    $form->activeFields()->get()->all()
                )
            );

            // 5. Save GDrive IDs back to the form record
            $form->update([
                'gdriveFolderID'             => $gdriveResult['gdriveFolderID'],
                'gdriveSpreadsheetID'        => $gdriveResult['gdriveSpreadsheetID'],
                'gdriveSpreadsheetUrl'       => $gdriveResult['gdriveSpreadsheetUrl'],
                'gdriveAttachmentsFolderID'  => $gdriveResult['gdriveAttachmentsFolderID'],
                'gdriveAttachmentsFolderUrl' => $gdriveResult['gdriveAttachmentsFolderUrl'],
            ]);

            // 6. Audit log
            TrFormAuditLog::recordAction($form->formID, TrFormAuditLog::ACTION_CREATE, [
                'title' => $form->title,
                'slug'  => $form->slug,
            ]);

            Alert::success('Created!', "Form \"{$form->title}\" was created. Start building your form fields.");
            return redirect()->route('admin.forms.builder', $form->formID);

        } catch (\Throwable $e) {
            Log::error('[AdminFormController::store] ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            Alert::error('Error', 'An error occurred while creating the form: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // -------------------------------------------------------------------------
    // Show (detail view with submissions summary)
    // -------------------------------------------------------------------------

    public function show(int $id)
    {
        $form = MsForm::with(['activeFields', 'sections'])->where('flagActive', true)->findOrFail($id);

        return view('admin-page.forms.view', compact('form'))
            ->with('title', 'Dynamic Forms');
    }

    // -------------------------------------------------------------------------
    // Form Builder (drag-drop field editor)
    // -------------------------------------------------------------------------

    public function builder(int $id)
    {
        $form = MsForm::with(['activeFields', 'sections'])->where('flagActive', true)->findOrFail($id);

        $fieldTypes = self::getFieldTypeDefinitions();

        return view('admin-page.forms.builder', compact('form', 'fieldTypes'))
            ->with('title', 'Dynamic Forms');
    }

    // -------------------------------------------------------------------------
    // Edit / Update (form metadata only — fields are updated via builder)
    // -------------------------------------------------------------------------

    public function edit(int $id)
    {
        $form = MsForm::where('flagActive', true)->findOrFail($id);

        return view('admin-page.forms.edit', compact('form'))
            ->with('title', 'Dynamic Forms');
    }

    public function update(Request $request, int $id)
    {
        $form = MsForm::where('flagActive', true)->findOrFail($id);

        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'description'         => 'nullable|string|max:2000',
            'maxSubmission'       => 'nullable|integer|min:1',
            'startDate'           => 'nullable|date',
            'endDate'             => 'nullable|date|after_or_equal:startDate',
            'confirmationMessage' => 'nullable|string|max:1000',
            'redirectUrl'         => 'nullable|url|max:500',
            'collaboratorEmails'  => 'nullable|string',
        ]);

        try {
            $before = $form->only(['title', 'status', 'startDate', 'endDate']);

            $newCollaborators = self::parseEmailList($validated['collaboratorEmails'] ?? '');
            $oldCollaborators = $form->collaboratorEmails ?? [];

            $form->update([
                'title'               => $validated['title'],
                'description'         => $validated['description']         ?? null,
                'maxSubmission'       => $validated['maxSubmission']       ?? null,
                'startDate'           => $validated['startDate']           ?? null,
                'endDate'             => $validated['endDate']             ?? null,
                'confirmationMessage' => $validated['confirmationMessage'] ?? null,
                'redirectUrl'         => $validated['redirectUrl']         ?? null,
                'collaboratorEmails'  => $newCollaborators,
                'editedBy'            => auth()->user()->email,
                'editedDate'          => Carbon::now(),
                'version'             => $form->version + 1,
            ]);

            // Update GDrive permissions for newly added/removed collaborators
            if ($form->gdriveFolderID) {
                $this->syncCollaboratorPermissions(
                    $form->gdriveFolderID,
                    $oldCollaborators,
                    $newCollaborators
                );
            }

            TrFormAuditLog::recordAction($form->formID, TrFormAuditLog::ACTION_UPDATE, [
                'before' => $before,
                'after'  => $form->only(['title', 'status', 'startDate', 'endDate']),
            ]);

            Alert::success('Saved!', 'Changes saved successfully.');
            return redirect()->route('admin.forms.index');

        } catch (\Throwable $e) {
            Log::error('[AdminFormController::update] ' . $e->getMessage());
            Alert::error('Error', 'Failed to save changes: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // -------------------------------------------------------------------------
    // Publish / Close / Archive actions
    // -------------------------------------------------------------------------

    public function publish(Request $request, int $id)
    {
        $form = MsForm::where('flagActive', true)->findOrFail($id);

        $form->update([
            'status'     => 'published',
            'editedBy'   => auth()->user()->email,
            'editedDate' => Carbon::now(),
        ]);

        TrFormAuditLog::recordAction($form->formID, TrFormAuditLog::ACTION_PUBLISH);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => "Form \"{$form->title}\" is now live."]);
        }

        Alert::success('Published!', "Form \"{$form->title}\" is now live and accepting submissions.");
        return redirect()->route('admin.forms.show', $form->formID);
    }

    public function close(Request $request, int $id)
    {
        $form = MsForm::where('flagActive', true)->findOrFail($id);

        $form->update([
            'status'     => 'closed',
            'editedBy'   => auth()->user()->email,
            'editedDate' => Carbon::now(),
        ]);

        TrFormAuditLog::recordAction($form->formID, TrFormAuditLog::ACTION_CLOSE);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => "Form \"{$form->title}\" has been closed."]);
        }

        Alert::success('Closed', "Form \"{$form->title}\" has been closed. No new submissions will be accepted.");
        return redirect()->route('admin.forms.show', $form->formID);
    }

    // -------------------------------------------------------------------------
    // Delete (soft delete via flagActive)
    // -------------------------------------------------------------------------

    public function destroy(int $id)
    {
        $form = MsForm::where('flagActive', true)->findOrFail($id);

        // Delete the GDrive folder (contains spreadsheet + attachments) — non-fatal
        if ($form->gdriveFolderID) {
            (new DynamicFormGDriveService())->deleteFormFolder($form->gdriveFolderID);
        }

        $form->update([
            'flagActive' => false,
            'editedBy'   => auth()->user()->email,
            'editedDate' => Carbon::now(),
        ]);

        TrFormAuditLog::recordAction($form->formID, TrFormAuditLog::ACTION_DELETE, [
            'title' => $form->title,
        ]);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => "Form \"{$form->title}\" has been deleted."]);
        }

        Alert::success('Deleted', "Form \"{$form->title}\" has been deleted.");
        return redirect()->route('admin.forms.index');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No forms selected for deletion.'], 400);
        }

        try {
            $forms        = MsForm::whereIn('formID', $ids)->where('flagActive', true)->get();
            $deleted      = 0;
            $now          = Carbon::now();
            $editor       = auth()->user()->email;
            $gdriveService = new DynamicFormGDriveService();

            foreach ($forms as $form) {
                // Delete GDrive folder (non-fatal)
                if ($form->gdriveFolderID) {
                    $gdriveService->deleteFormFolder($form->gdriveFolderID);
                }

                $form->update([
                    'flagActive' => false,
                    'editedBy'   => $editor,
                    'editedDate' => $now,
                ]);
                TrFormAuditLog::recordAction($form->formID, TrFormAuditLog::ACTION_DELETE, [
                    'title' => $form->title,
                ]);
                $deleted++;
            }

            return response()->json([
                'success' => true,
                'message' => "{$deleted} form(s) have been deleted.",
            ]);

        } catch (\Throwable $e) {
            Log::error('[AdminFormController::bulkDelete] ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting forms: ' . $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // FORM BUILDER — AJAX field management
    // All methods below are called via AJAX from the builder UI
    // =========================================================================

    /**
     * Add a new field to the form.
     */
    public function addField(Request $request, int $formID)
    {
        $form = MsForm::where('flagActive', true)->findOrFail($formID);

        $validated = $request->validate([
            'fieldType'              => 'required|string|in:short_text,long_text,email,number,phone,url,date,time,datetime,dropdown,radio,checkbox,file,image,section_break,paragraph',
            'label'                  => 'required|string|max:500',
            'placeholder'            => 'nullable|string|max:255',
            'helpText'               => 'nullable|string|max:500',
            'isRequired'             => 'nullable|boolean',
            'formSectionID'          => 'nullable|integer|exists:ms_form_section,formSectionID',
            'options'                => 'nullable|array',
            'options.*.label'        => 'required_with:options|string|max:255',
            'options.*.value'        => 'required_with:options|string|max:255',
            'validation'             => 'nullable|array',
            'validation.maxSizeKB'   => 'nullable|integer|min:1',
            'validation.acceptedTypes' => 'nullable|array',
        ]);

        try {
            $now = Carbon::now();

            // Determine next sort order
            $maxOrder = MsFormField::where('formID', $formID)
                                   ->where('flagActive', true)
                                   ->max('sortOrder') ?? 0;

            $field = MsFormField::create([
                'formID'        => $formID,
                'formSectionID' => $validated['formSectionID']  ?? null,
                'fieldType'     => $validated['fieldType'],
                'label'         => $validated['label'],
                'placeholder'   => $validated['placeholder']   ?? null,
                'helpText'      => $validated['helpText']       ?? null,
                'isRequired'    => (bool) ($validated['isRequired'] ?? false),
                'isSystemField' => false,
                'sortOrder'     => $maxOrder + 1,
                'options'       => $validated['options']        ?? null,
                'validation'    => $validated['validation']     ?? null,
                'flagActive'    => true,
                'createdDate'   => $now,
            ]);

            // If this is a file/image field, create its GDrive subfolder
            if ($field->isFileUpload() && $form->gdriveAttachmentsFolderID) {
                $this->createFieldGdriveFolder($form, $field);
            }

            // Regenerate spreadsheet header row to include this new field
            $this->regenerateSpreadsheetHeaders($form);

            TrFormAuditLog::recordAction($form->formID, TrFormAuditLog::ACTION_ADD_FIELD, [
                'fieldID'   => $field->formFieldID,
                'fieldType' => $field->fieldType,
                'label'     => $field->label,
            ]);

            // Increment form version
            $form->increment('version');

            return response()->json([
                'success' => true,
                'field'   => $field,
                'html'    => view('admin-page.forms.components._field-card', compact('field'))->render(),
            ]);

        } catch (\Throwable $e) {
            Log::error('[AdminFormController::addField] ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update a single field's configuration.
     */
    public function updateField(Request $request, int $formID, int $fieldID)
    {
        $form  = MsForm::findOrFail($formID);
        $field = MsFormField::where('formID', $formID)
                            ->where('formFieldID', $fieldID)
                            ->where('flagActive', true)
                            ->firstOrFail();

        // System fields can have their label updated but not removed or type-changed
        $validated = $request->validate([
            'label'         => 'required|string|max:500',
            'placeholder'   => 'nullable|string|max:255',
            'helpText'      => 'nullable|string|max:500',
            'isRequired'    => 'nullable|boolean',
            'options'       => 'nullable|array',
            'validation'    => 'nullable|array',
            'defaultValue'  => 'nullable|string|max:1000',
        ]);

        $labelChanged = $field->label !== $validated['label'];

        $field->update([
            'label'        => $validated['label'],
            'placeholder'  => $validated['placeholder']  ?? null,
            'helpText'     => $validated['helpText']      ?? null,
            'isRequired'   => (bool) ($validated['isRequired'] ?? false),
            'options'      => $validated['options']       ?? null,
            'validation'   => $validated['validation']    ?? null,
            'defaultValue' => $validated['defaultValue']  ?? null,
            'editedDate'   => Carbon::now(),
        ]);

        $form->increment('version');

        // Sync spreadsheet header column name if label changed
        if ($labelChanged) {
            $this->regenerateSpreadsheetHeaders($form);
        }

        return response()->json(['success' => true, 'field' => $field->fresh()]);
    }

    /**
     * Soft-delete a field (cannot delete system fields).
     */
    public function removeField(int $formID, int $fieldID)
    {
        $form  = MsForm::findOrFail($formID);
        $field = MsFormField::where('formID', $formID)
                            ->where('formFieldID', $fieldID)
                            ->where('flagActive', true)
                            ->firstOrFail();

        if ($field->isSystemField) {
            return response()->json(['success' => false, 'message' => 'System fields cannot be deleted.'], 422);
        }

        // Capture GDrive folder ID before soft-delete (file/image fields only)
        $fieldGdriveFolderID = $field->fieldConfig['gdriveFolderID'] ?? null;

        $field->update([
            'flagActive' => false,
            'editedDate' => Carbon::now(),
        ]);

        TrFormAuditLog::recordAction($formID, TrFormAuditLog::ACTION_REMOVE_FIELD, [
            'fieldID' => $fieldID,
            'label'   => $field->label,
        ]);

        $form->increment('version');

        // Remove column from spreadsheet and delete field's GDrive folder if applicable
        $this->regenerateSpreadsheetHeaders($form);

        if ($fieldGdriveFolderID) {
            try {
                (new DynamicFormGDriveService())->deleteFormFolder($fieldGdriveFolderID);
            } catch (\Throwable $e) {
                Log::error('[AdminFormController::removeField] GDrive folder deletion failed: ' . $e->getMessage());
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * Reorder fields by accepting an ordered array of formFieldID values.
     * Also reorders the Google Spreadsheet columns to match the new field order.
     */
    public function reorderFields(Request $request, int $formID)
    {
        $validated = $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer',
        ]);

        try {
            foreach ($validated['order'] as $sortOrder => $fieldID) {
                MsFormField::where('formFieldID', $fieldID)
                           ->where('formID', $formID)
                           ->update(['sortOrder' => $sortOrder]);
            }

            $form = MsForm::findOrFail($formID);
            $form->increment('version');

            // Reorder spreadsheet columns to match the new field order
            if ($form->gdriveSpreadsheetID) {
                try {
                    $fields  = $form->activeFields()->get()->all();
                    $headers = DynamicFormGDriveService::buildSpreadsheetHeaders($fields);
                    (new DynamicFormGDriveService())->reorderSpreadsheetColumns($form->gdriveSpreadsheetID, $headers);
                } catch (\Throwable $e) {
                    Log::warning('[AdminFormController::reorderFields] Spreadsheet column reorder failed: ' . $e->getMessage());
                    // Non-fatal — field order in DB is still saved correctly
                }
            }

            return response()->json(['success' => true]);

        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // Private helpers
    // =========================================================================

    /**
     * Parse a comma- or newline-separated string of emails into a clean array.
     */
    private static function parseEmailList(string $raw): array
    {
        if (empty(trim($raw))) {
            return [];
        }

        return array_values(array_filter(
            array_map('trim', preg_split('/[\s,;]+/', $raw)),
            fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL)
        ));
    }

    /**
     * Create a GDrive subfolder for a file/image field and store its ID
     * in the field's fieldConfig JSON.
     */
    private function createFieldGdriveFolder(MsForm $form, MsFormField $field): void
    {
        try {
            $service = new DynamicFormGDriveService();

            $result = $service->setupFormFolder(
                formTitle:          $form->title,
                creatorEmail:       auth()->user()->email,
                collaborators:      [],
                fileFieldLabels:    [$field->label],
                spreadsheetHeaders: []
            );

            // The last entry in fieldFolders is the one we just created
            $folderData = end($result['fieldFolders']);

            if ($folderData) {
                $config = $field->fieldConfig ?? [];
                $config['gdriveFolderID']            = $folderData['gdriveFolderID'];
                $config['gdriveAttachmentsFolderUrl'] = $folderData['gdriveAttachmentsFolderUrl'];

                $field->update(['fieldConfig' => $config]);
            }
        } catch (\Throwable $e) {
            Log::error('[AdminFormController::createFieldGdriveFolder] ' . $e->getMessage());
            // Non-fatal: field still saved, GDrive folder creation failure is logged
        }
    }

    /**
     * Re-write the first row of the spreadsheet with the current field labels.
     * Called whenever a field is added or removed.
     */
    private function regenerateSpreadsheetHeaders(MsForm $form): void
    {
        if (empty($form->gdriveSpreadsheetID)) {
            return;
        }

        try {
            $fields  = $form->activeFields()->get()->all();
            $headers = DynamicFormGDriveService::buildSpreadsheetHeaders($fields);

            (new DynamicFormGDriveService())->updateSpreadsheetHeaders($form->gdriveSpreadsheetID, $headers);

        } catch (\Throwable $e) {
            Log::error('[AdminFormController::regenerateSpreadsheetHeaders] ' . $e->getMessage());
        }
    }

    /**
     * Sync GDrive permissions when collaborator emails change.
     */
    private function syncCollaboratorPermissions(
        string $folderID,
        array  $oldEmails,
        array  $newEmails
    ): void {
        try {
            $service = new DynamicFormGDriveService();

            // Grant access to newly added collaborators
            $toAdd = array_diff($newEmails, $oldEmails);
            foreach ($toAdd as $email) {
                $service->grantEditorAccess($folderID, $email);
            }

            // Revoke access from removed collaborators
            $toRemove = array_diff($oldEmails, $newEmails);
            foreach ($toRemove as $email) {
                $service->revokeAccess($folderID, $email);
            }
        } catch (\Throwable $e) {
            Log::error('[AdminFormController::syncCollaboratorPermissions] ' . $e->getMessage());
        }
    }

    // -------------------------------------------------------------------------
    // Field type metadata — used by the builder UI to render the field palette
    // -------------------------------------------------------------------------

    public static function getFieldTypeDefinitions(): array
    {
        return [
            ['type' => 'short_text',   'label' => 'Short Text',     'icon' => 'fa-font',               'group' => 'Text'],
            ['type' => 'long_text',    'label' => 'Long Text',      'icon' => 'fa-align-left',         'group' => 'Text'],
            ['type' => 'email',        'label' => 'Email',          'icon' => 'fa-envelope',           'group' => 'Text'],
            ['type' => 'number',       'label' => 'Number',         'icon' => 'fa-hashtag',            'group' => 'Text'],
            ['type' => 'phone',        'label' => 'Phone',          'icon' => 'fa-phone',              'group' => 'Text'],
            ['type' => 'url',          'label' => 'URL / Link',     'icon' => 'fa-link',               'group' => 'Text'],
            ['type' => 'date',         'label' => 'Date',           'icon' => 'fa-calendar',           'group' => 'Date & Time'],
            ['type' => 'time',         'label' => 'Time',           'icon' => 'fa-clock',              'group' => 'Date & Time'],
            ['type' => 'datetime',     'label' => 'Date & Time',    'icon' => 'fa-calendar-alt',       'group' => 'Date & Time'],
            ['type' => 'dropdown',     'label' => 'Dropdown',       'icon' => 'fa-chevron-circle-down','group' => 'Choice'],
            ['type' => 'radio',        'label' => 'Multiple Choice', 'icon' => 'fa-dot-circle',        'group' => 'Choice'],
            ['type' => 'checkbox',     'label' => 'Checkboxes',     'icon' => 'fa-check-square',       'group' => 'Choice'],
            ['type' => 'file',         'label' => 'File Upload',    'icon' => 'fa-file-upload',        'group' => 'Upload'],
            ['type' => 'image',        'label' => 'Image Upload',   'icon' => 'fa-image',              'group' => 'Upload'],
            ['type' => 'section_break','label' => 'Section Break',  'icon' => 'fa-minus',              'group' => 'Layout'],
            ['type' => 'paragraph',    'label' => 'Paragraph Text', 'icon' => 'fa-paragraph',          'group' => 'Layout'],
        ];
    }
}
