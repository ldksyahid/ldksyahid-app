<?php

namespace App\Http\Controllers;

use App\Jobs\SendSingleMailJob;
use App\Mail\FormSubmissionConfirmation;
use App\Models\forms\MsForm;
use App\Models\forms\MsFormField;
use App\Models\forms\MsFormSetting;
use App\Models\forms\TrFormAuditLog;
use App\Models\forms\TrFormFile;
use App\Models\forms\TrFormSubmission;
use App\Services\DynamicFormGDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class PublicFormController extends Controller
{
    // -------------------------------------------------------------------------
    // Show the public form
    // -------------------------------------------------------------------------

    /**
     * Display a published, active form for public submission.
     */
    public function show(string $slug)
    {
        $form = MsForm::where('slug', $slug)
                      ->where('flagActive', true)
                      ->firstOrFail();

        // Build the closed/unavailable message before returning
        if (!$form->isAcceptingSubmissions()) {
            return view('landing-page.forms.closed', compact('form'))
                ->with('title', $form->title);
        }

        $fields = $form->activeFields()->get();

        return view('landing-page.forms.show', compact('form', 'fields'))
            ->with('title', $form->title);
    }

    // -------------------------------------------------------------------------
    // Handle submission
    // -------------------------------------------------------------------------

    /**
     * Process a form submission.
     *
     * Pipeline:
     * 1. Anti-spam check (honeypot + timing)
     * 2. Rate limit check
     * 3. Validate all fields dynamically
     * 4. Upload files to GDrive
     * 5. Append answers to Google Sheets
     * 6. Record metadata in tr_form_submission + tr_form_file
     * 7. Increment form submission counter
     * 8. Dispatch confirmation email job
     * 9. Redirect to thank-you or confirmation message
     */
    public function submit(Request $request, string $slug)
    {
        $form = MsForm::where('slug', $slug)
                      ->where('flagActive', true)
                      ->firstOrFail();

        // 1a. Honeypot check — bots fill hidden fields, humans don't
        if (!empty($request->input('_hp_website'))) {
            // Silently succeed to not reveal the check to bots
            return $this->successResponse($form, $request);
        }

        // 1b. Timing check — submissions in under 3 seconds are likely bots
        $startTime = $request->input('_form_ts');
        if ($startTime && is_numeric($startTime)) {
            $elapsed = time() - (int) $startTime;
            if ($elapsed < 3) {
                Log::warning('[PublicFormController] Possible bot submission.', [
                    'ip'       => $request->ip(),
                    'form'     => $slug,
                    'elapsed'  => $elapsed,
                ]);
                return $this->successResponse($form, $request);
            }
        }

        // 2. Rate limit check
        if (TrFormSubmission::isRateLimited($form->formID, $request->ip())) {
            return back()
                ->withErrors(['rate_limit' => 'Terlalu banyak pengiriman formulir. Silakan coba lagi beberapa saat kemudian.'])
                ->withInput();
        }

        // 3. Check if form is still accepting submissions (could have closed between page load and submit)
        if (!$form->isAcceptingSubmissions()) {
            return view('landing-page.forms.closed', compact('form'))
                ->with('title', $form->title);
        }

        // 4. Build and run dynamic validation rules
        $activeFields = $form->activeFields()->get();
        $rules        = [];
        $messages     = [];

        foreach ($activeFields as $field) {
            if ($field->isDisplayOnly()) {
                continue;
            }

            $fieldKey         = 'field_' . $field->formFieldID;
            $rules[$fieldKey] = $field->buildValidationRules();

            // Indonesian validation messages per field
            $lbl = "\"{$field->label}\"";
            $messages[$fieldKey . '.required']   = "Kolom {$lbl} wajib diisi.";
            $messages[$fieldKey . '.email']       = "Format email pada kolom {$lbl} tidak valid.";
            $messages[$fieldKey . '.url']         = "Format URL pada kolom {$lbl} tidak valid. Gunakan awalan https://.";
            $messages[$fieldKey . '.numeric']     = "Kolom {$lbl} harus berupa angka.";
            $messages[$fieldKey . '.integer']     = "Kolom {$lbl} harus berupa bilangan bulat.";
            $messages[$fieldKey . '.min']         = "Kolom {$lbl} harus memiliki minimal :min karakter.";
            $messages[$fieldKey . '.max']         = "Kolom {$lbl} tidak boleh lebih dari :max karakter.";
            $messages[$fieldKey . '.min.numeric'] = "Nilai kolom {$lbl} minimal adalah :min.";
            $messages[$fieldKey . '.max.numeric'] = "Nilai kolom {$lbl} maksimal adalah :max.";
            $messages[$fieldKey . '.date']        = "Format tanggal pada kolom {$lbl} tidak valid.";
            $messages[$fieldKey . '.before']      = "Tanggal pada kolom {$lbl} harus sebelum :date.";
            $messages[$fieldKey . '.after']       = "Tanggal pada kolom {$lbl} harus setelah :date.";
            $messages[$fieldKey . '.file']        = "Kolom {$lbl} harus berupa file yang valid.";
            $messages[$fieldKey . '.image']       = "File pada kolom {$lbl} harus berupa gambar (jpg, png, dll).";
            $messages[$fieldKey . '.mimes']       = "Format file pada kolom {$lbl} tidak didukung.";
            $messages[$fieldKey . '.mimetypes']   = "Format file pada kolom {$lbl} tidak didukung.";
            $messages[$fieldKey . '.max.file']    = "Ukuran file pada kolom {$lbl} tidak boleh lebih dari :max KB.";
            $messages[$fieldKey . '.regex']       = "Format isian pada kolom {$lbl} tidak valid.";
            $messages[$fieldKey . '.in']          = "Pilihan pada kolom {$lbl} tidak valid.";
        }

        $validated = $request->validate($rules, $messages);

        // 5. Retrieve the system email field value
        $emailField    = $activeFields->firstWhere('isSystemField', true);
        $emailFieldKey = $emailField ? 'field_' . $emailField->formFieldID : null;
        $respondentEmail = $emailFieldKey ? ($validated[$emailFieldKey] ?? '') : '';

        // Guess respondent name from a field labelled "Nama" / "Name" if present
        $respondentName = '';
        $nameField = $activeFields->first(fn ($f) =>
            in_array(strtolower($f->label), ['nama', 'name', 'nama lengkap', 'full name'])
        );
        if ($nameField) {
            $respondentName = $validated['field_' . $nameField->formFieldID] ?? '';
        }

        try {
            $gdriveService = new DynamicFormGDriveService();

            // 6. Build the row data array for Google Sheets
            //    Columns: Timestamp | Submission ID (placeholder) | Field 1 | Field 2 | ...
            $now       = Carbon::now();
            $rowData   = [$now->toDateTimeString(), '—']; // placeholder for Submission ID

            $answerMap = []; // label => value (for the confirmation email)

            foreach ($activeFields as $field) {
                if ($field->isDisplayOnly()) {
                    continue;
                }

                $fieldKey = 'field_' . $field->formFieldID;

                if ($field->isFileUpload()) {
                    // File is uploaded in the next step; use placeholder for now
                    $rowData[]            = '[file pending]';
                    $answerMap[$field->label] = '[file]';
                } else {
                    $value = $validated[$fieldKey] ?? '';

                    // For arrays (checkbox), join values
                    if (is_array($value)) {
                        $value = implode(', ', $value);
                    }

                    $rowData[]                = $value;
                    $answerMap[$field->label] = $value;
                }
            }

            // 7. Append to Google Sheets → get row index
            $gsheetRowIndex = null;
            if ($form->gdriveSpreadsheetID) {
                $gsheetRowIndex = $gdriveService->appendSubmissionToSheet(
                    $form->gdriveSpreadsheetID,
                    $rowData
                );
            }

            // 8. Record submission metadata in DB
            $submission = TrFormSubmission::record(
                formID:         $form->formID,
                email:          $respondentEmail,
                name:           $respondentName ?: null,
                phone:          null,
                gsheetRowIndex: $gsheetRowIndex,
                ipAddress:      $request->ip(),
                userAgent:      $request->userAgent() ?? '',
                formVersion:    $form->version
            );

            // 9. Update submission ID placeholder in the sheet
            if ($form->gdriveSpreadsheetID && $gsheetRowIndex) {
                $gdriveService->updateCell(
                    $form->gdriveSpreadsheetID,
                    $gsheetRowIndex,
                    1, // column index 1 = "Submission ID" (0-based: col B)
                    (string) $submission->formSubmissionID
                );
            }

            // 10. Upload files and update sheet cells + DB
            $fileColOffset = 2; // Timestamp(0) + SubmissionID(1) = files start at col 2
            foreach ($activeFields as $fieldColIdx => $field) {
                if (!$field->isFileUpload()) {
                    // Advance col offset for non-display fields
                    if (!$field->isDisplayOnly()) {
                        $fileColOffset++;
                    }
                    continue;
                }

                $fieldKey = 'field_' . $field->formFieldID;
                $file     = $request->file($fieldKey);

                if (!$file) {
                    $fileColOffset++;
                    continue;
                }

                $gdriveFolderID = $field->getGdriveFolderID();

                if ($gdriveFolderID) {
                    $uploadResult = $gdriveService->uploadFileToFieldFolder(
                        $gdriveFolderID,
                        $file,
                        $submission->formSubmissionID
                    );

                    // Record file in DB
                    TrFormFile::record(
                        submissionID:      $submission->formSubmissionID,
                        fieldID:           $field->formFieldID,
                        originalFileName:  $uploadResult['originalFileName'],
                        mimeType:          $uploadResult['mimeType'],
                        fileSizeKB:        $uploadResult['fileSizeKB'],
                        gdriveFileID:      $uploadResult['gdriveFileID'],
                        gdriveFolderID:    $gdriveFolderID,
                        gdriveFileUrl:     $uploadResult['gdriveFileUrl']
                    );

                    // Update the sheet cell from placeholder to GDrive link
                    if ($form->gdriveSpreadsheetID && $gsheetRowIndex) {
                        $gdriveService->updateCell(
                            $form->gdriveSpreadsheetID,
                            $gsheetRowIndex,
                            $fileColOffset,
                            $uploadResult['gdriveFileUrl']
                        );
                    }

                    $answerMap[$field->label] = $uploadResult['gdriveFileUrl'];
                }

                $fileColOffset++;
            }

            // 11. Increment form submission counter
            $form->incrementSubmissionCount();

            // 12. Dispatch confirmation email to respondent (queued or sync depending on env)
            $sendConfirmEmail = (bool) $form->getSetting(MsFormSetting::KEY_SEND_CONFIRM_EMAIL, true);
            if ($sendConfirmEmail && !empty($respondentEmail)) {
                $mailable = new FormSubmissionConfirmation(
                    formTitle:      $form->title,
                    respondentName: $respondentName,
                    answers:        $answerMap,
                    submittedAt:    $now->timezone('Asia/Jakarta')->format('d F Y, H:i') . ' WIB',
                );

                dispatch(new SendSingleMailJob($respondentEmail, $mailable));
            }

            return $this->successResponse($form, $request, $submission->formSubmissionID);

        } catch (\Throwable $e) {
            Log::error('[PublicFormController::submit] ' . $e->getMessage(), [
                'form'  => $slug,
                'ip'    => $request->ip(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withErrors(['error' => 'Terjadi kesalahan saat memproses formulir Anda. Silakan coba lagi.'])
                ->withInput();
        }
    }

    // -------------------------------------------------------------------------
    // Thank you page
    // -------------------------------------------------------------------------

    public function thankYou(string $slug)
    {
        $form = MsForm::where('slug', $slug)->where('flagActive', true)->firstOrFail();

        return view('landing-page.forms.thank-you', compact('form'))
            ->with('title', 'Thank You – ' . $form->title);
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Return the appropriate success response (redirect or custom URL).
     */
    private function successResponse(MsForm $form, Request $request, ?int $submissionID = null)
    {
        if ($form->redirectUrl) {
            return redirect($form->redirectUrl);
        }

        return redirect()->route('forms.thank-you', $form->slug);
    }
}
