<?php

namespace App\Http\Controllers;

use App\Mail\FormSubmissionConfirmation;
use App\Models\forms\MsForm;
use App\Models\forms\MsFormSetting;
use App\Models\forms\TrFormFile;
use App\Models\forms\TrFormSubmission;
use App\Services\DynamicFormGDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PublicFormController extends Controller
{
    // -------------------------------------------------------------------------
    // Show the public form
    // -------------------------------------------------------------------------

    public function show(string $slug)
    {
        $form = MsForm::where('slug', $slug)
                      ->where('flagActive', true)
                      ->firstOrFail();

        // 1. Must be logged in to access the form
        if (!auth()->check()) {
            session()->put('url.intended', url()->current());
            return view('landing-page.forms.closed', compact('form'))
                ->with('title', $form->title)
                ->with('needsLogin', true);
        }

        // 2. Check if form is accepting submissions
        if (!$form->isAcceptingSubmissions()) {
            return view('landing-page.forms.closed', compact('form'))
                ->with('title', $form->title);
        }

        // 3. Single-submission check via logged-in user's email
        if (!$form->isMultipleSubmit) {
            $userEmail = auth()->user()->email;
            if (TrFormSubmission::hasSubmittedBefore($form->formID, $userEmail)) {
                return view('landing-page.forms.closed', compact('form'))
                    ->with('title', $form->title)
                    ->with('alreadySubmitted', true);
            }
        }

        $fields = $form->activeFields()->get();

        return view('landing-page.forms.show', compact('form', 'fields'))
            ->with('title', $form->title);
    }

    // -------------------------------------------------------------------------
    // Handle submission
    // -------------------------------------------------------------------------

    public function submit(Request $request, string $slug)
    {
        $form = MsForm::where('slug', $slug)
                      ->where('flagActive', true)
                      ->firstOrFail();

        // 0. Must be authenticated
        if (!auth()->check()) {
            $msg = 'Anda harus login terlebih dahulu untuk mengisi formulir ini.';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $msg], 401);
            }
            return redirect()->route('login');
        }

        $userEmail = auth()->user()->email;

        // 1a. Honeypot check
        if (!empty($request->input('_hp_website'))) {
            return $this->successResponse($form, $request);
        }

        // 1b. Timing check — submissions under 3 seconds are likely bots
        $startTime = $request->input('_form_ts');
        if ($startTime && is_numeric($startTime)) {
            $elapsed = time() - (int) $startTime;
            if ($elapsed < 3) {
                Log::error('[PublicFormController] Possible bot submission.', [
                    'ip'      => $request->ip(),
                    'form'    => $slug,
                    'elapsed' => $elapsed,
                ]);
                return $this->successResponse($form, $request);
            }
        }

        // 2. Rate limit check
        if (TrFormSubmission::isRateLimited($form->formID, $request->ip())) {
            $msg = 'Terlalu banyak pengiriman formulir. Silakan coba lagi beberapa saat kemudian.';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $msg], 429);
            }
            return back()->withErrors(['rate_limit' => $msg])->withInput();
        }

        // 3. Check if form is still accepting submissions
        if (!$form->isAcceptingSubmissions()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Formulir ini sudah tidak menerima pengisian.'], 422);
            }
            return view('landing-page.forms.closed', compact('form'))
                ->with('title', $form->title);
        }

        // 4. Single-submission check via logged-in user's email
        if (!$form->isMultipleSubmit && TrFormSubmission::hasSubmittedBefore($form->formID, $userEmail)) {
            $msg = 'Email ' . $userEmail . ' sudah pernah digunakan untuk mengisi formulir ini.';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return view('landing-page.forms.closed', compact('form'))
                ->with('title', $form->title)
                ->with('alreadySubmitted', true);
        }

        // 5. Build and run dynamic validation rules
        $activeFields = $form->activeFields()->get();
        $rules        = [];
        $messages     = [];

        foreach ($activeFields as $field) {
            if ($field->isDisplayOnly()) {
                continue;
            }

            $fieldKey         = 'field_' . $field->formFieldID;
            $rules[$fieldKey] = $field->buildValidationRules();

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

        // 6. Use logged-in user's email as the respondent email
        $respondentEmail = $userEmail;

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

            // 7. Build the row data array for Google Sheets
            $now     = Carbon::now();
            $rowData = [$now->toDateTimeString(), '—'];

            $answerMap = [];

            foreach ($activeFields as $field) {
                if ($field->isDisplayOnly()) {
                    continue;
                }

                $fieldKey = 'field_' . $field->formFieldID;

                if ($field->isFileUpload()) {
                    $rowData[]                = '[file pending]';
                    $answerMap[$field->label] = '[file]';
                } else {
                    $value = $validated[$fieldKey] ?? '';

                    if (is_array($value)) {
                        $value = implode(', ', $value);
                    }

                    $rowData[]                = $value;
                    $answerMap[$field->label] = $value;
                }
            }

            // 8. Append to Google Sheets
            $gsheetRowIndex = null;
            if ($form->gdriveSpreadsheetID) {
                $gsheetRowIndex = $gdriveService->appendSubmissionToSheet(
                    $form->gdriveSpreadsheetID,
                    $rowData
                );
            }

            // 9. Record submission metadata in DB
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

            // 10. Update submission ID placeholder in the sheet
            if ($form->gdriveSpreadsheetID && $gsheetRowIndex) {
                $gdriveService->updateCell(
                    $form->gdriveSpreadsheetID,
                    $gsheetRowIndex,
                    1,
                    (string) $submission->formSubmissionID
                );
            }

            // 11. Upload files and update sheet cells + DB
            $fileColOffset = 2;
            foreach ($activeFields as $field) {
                if (!$field->isFileUpload()) {
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

            // 12. Increment form submission counter
            $form->incrementSubmissionCount();

            // 13. Send confirmation email directly via Gmail
            $sendConfirmEmail = (bool) $form->getSetting(MsFormSetting::KEY_SEND_CONFIRM_EMAIL, true);
            if ($sendConfirmEmail && !empty($respondentEmail)) {
                try {
                    Mail::mailer('gmail')
                        ->to($respondentEmail)
                        ->send(new FormSubmissionConfirmation(
                            formTitle:      $form->title,
                            respondentName: $respondentName,
                            answers:        $answerMap,
                            submittedAt:    $now->timezone('Asia/Jakarta')->format('d F Y, H:i') . ' WIB',
                        ));
                } catch (\Throwable $e) {
                    Log::error('[PublicFormController] Failed to send confirmation email: ' . $e->getMessage(), [
                        'form'  => $slug,
                        'email' => $respondentEmail,
                    ]);
                }
            }

            return $this->successResponse($form, $request);

        } catch (\Throwable $e) {
            Log::error('[PublicFormController::submit] ' . $e->getMessage(), [
                'form'  => $slug,
                'ip'    => $request->ip(),
                'trace' => $e->getTraceAsString(),
            ]);

            $msg = 'Terjadi kesalahan saat memproses formulir Anda. Silakan coba lagi.';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $msg], 500);
            }
            return back()->withErrors(['error' => $msg])->withInput();
        }
    }

    // -------------------------------------------------------------------------
    // Thank you page
    // -------------------------------------------------------------------------

    public function thankYou(string $slug)
    {
        $form = MsForm::where('slug', $slug)->where('flagActive', true)->firstOrFail();

        return view('landing-page.forms.thank-you', compact('form'))
            ->with('title', 'Terima Kasih – ' . $form->title);
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    private function successResponse(MsForm $form, Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'success'             => true,
                'redirectUrl'         => $form->redirectUrl ?: null,
                'formTitle'           => $form->title,
                'confirmationMessage' => $form->confirmationMessage ?: null,
                'isMultipleSubmit'    => (bool) $form->isMultipleSubmit,
                'formSlug'            => $form->slug,
            ]);
        }

        if ($form->redirectUrl) {
            return redirect($form->redirectUrl);
        }

        return redirect()->route('forms.thank-you', $form->slug);
    }
}
