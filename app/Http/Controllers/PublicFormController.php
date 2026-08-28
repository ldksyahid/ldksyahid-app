<?php

namespace App\Http\Controllers;

use App\Jobs\UploadFormFileToGDriveJob;
use App\Mail\FormSubmissionConfirmation;
use App\Models\forms\MsForm;
use App\Models\forms\MsFormSetting;
use App\Models\forms\TrFormDraft;
use App\Models\forms\TrFormSubmission;
use App\Services\DynamicFormGDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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

        // 2. Privilege check — superadmin, creator, and collaborators can preview closed/draft forms.
        /** @var \App\Models\User $user */
        $user         = auth()->user();
        $collabs      = $form->collaboratorEmails ?: [];
        $isPrivileged = $user->hasRole('Superadmin')
            || $form->createdBy === $user->email
            || $form->createdBy === $user->name
            || in_array($user->email, $collabs);

        $isAccepting = $form->isAcceptingSubmissions();

        // Non-privileged users are blocked when form is not accepting submissions
        if (!$isPrivileged && !$isAccepting) {
            return view('landing-page.forms.closed', compact('form'))
                ->with('title', $form->title);
        }

        // 3. Single-submission check — skip for privileged users (preview mode)
        if (!$isPrivileged && !$form->isMultipleSubmit) {
            $userEmail = auth()->user()->email;
            if (TrFormSubmission::hasSubmittedBefore($form->formID, $userEmail)) {
                return view('landing-page.forms.closed', compact('form'))
                    ->with('title', $form->title)
                    ->with('alreadySubmitted', true);
            }
        }

        $fields        = $form->activeFields()->get();
        // Pass preview flag so the form can show a notice when viewed while closed/draft
        $isPreviewMode = $isPrivileged && !$isAccepting;

        // Restore any in-progress draft for this user so answers survive a
        // refresh or a switch to another device (draft is account-based, not
        // per-browser). Each field partial falls back to it via old($key, $draft[$key]).
        $draftAnswers = TrFormDraft::findAnswers($form->formID, $user->id) ?? [];

        return view('landing-page.forms.show', compact('form', 'fields', 'isPreviewMode', 'draftAnswers'))
            ->with('title', $form->title);
    }

    // -------------------------------------------------------------------------
    // Autosave a partial draft (AJAX, debounced from the client)
    // -------------------------------------------------------------------------

    public function saveDraft(Request $request, string $slug)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false], 401);
        }

        $form = MsForm::where('slug', $slug)->where('flagActive', true)->first();
        if (!$form) {
            return response()->json(['success' => false], 404);
        }

        // Only persist keys that correspond to real, non-file, non-system fields
        // on this form — never trust arbitrary keys from the client; file inputs
        // can't be restored into a <input type="file"> anyway; and system fields
        // (e.g. the readonly auto-filled email) must always come fresh from the
        // logged-in account, never from a possibly-stale draft.
        $allowedKeys = $form->activeFields()
            ->get()
            ->reject(fn ($field) => $field->isDisplayOnly() || $field->isFileUpload() || $field->isSystemField)
            ->map(fn ($field) => 'field_' . $field->formFieldID)
            ->all();

        $answers = $request->only($allowedKeys);
        // Drop empty values so a cleared field doesn't linger in the draft
        $answers = array_filter($answers, fn ($v) => $v !== null && $v !== '' && $v !== []);

        if (empty($answers)) {
            TrFormDraft::clear($form->formID, auth()->id());
        } else {
            TrFormDraft::upsertAnswers($form->formID, auth()->id(), $answers);
        }

        return response()->json(['success' => true]);
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

        // Privilege check (same logic as show())
        /** @var \App\Models\User $authUser */
        $authUser        = auth()->user();
        $submitCollabs   = $form->collaboratorEmails ?: [];
        $isPrivilegedSub = $authUser->hasRole('Superadmin')
            || $form->createdBy === $authUser->email
            || $form->createdBy === $authUser->name
            || in_array($authUser->email, $submitCollabs);

        // 3. Check if form is still accepting submissions (skip for privileged)
        if (!$isPrivilegedSub && !$form->isAcceptingSubmissions()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Formulir ini sudah tidak menerima pengisian.'], 422);
            }
            return view('landing-page.forms.closed', compact('form'))
                ->with('title', $form->title);
        }

        // 4. Single-submission check (skip for privileged)
        if (!$isPrivilegedSub && !$form->isMultipleSubmit && TrFormSubmission::hasSubmittedBefore($form->formID, $userEmail)) {
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
                    // File uploads are processed by a background job (see step 11
                    // below), so the real Drive link isn't known yet when this
                    // confirmation email is sent — this placeholder is final for
                    // the email regardless of when the upload job completes.
                    $answerMap[$field->label] = '[File diterima, sedang diproses]';
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

                // Re-apply the Timestamp column's date format on this specific row.
                // A freshly INSERT_ROWS-appended row inherits formatting from whatever
                // row precedes it, which reverts to unformatted once older rows get
                // deleted — so this must run per-submission, not just once at sheet
                // creation, to keep displaying correctly.
                if ($gsheetRowIndex) {
                    $gdriveService->formatTimestampColumn($form->gdriveSpreadsheetID, $gsheetRowIndex);
                }
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

            // 11. Move uploaded files to local temp storage and hand them off to a
            // background job for the actual Drive upload — keeps this request fast
            // and resilient to a slow/flaky Drive API call. The job fills in the
            // TrFormFile row and overwrites the sheet's "[file pending]" cell once
            // the upload succeeds; forms:cleanup-stale-uploads sweeps up any temp
            // file left behind by a job that never completes (default: 3+ days old).
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
                    $tempRelativePath = Storage::disk('local')->putFileAs('form-uploads-tmp', $file, $file->hashName());

                    UploadFormFileToGDriveJob::dispatch(
                        $tempRelativePath,
                        $file->getClientOriginalName(),
                        $file->getMimeType() ?? 'application/octet-stream',
                        $gdriveFolderID,
                        $submission->formSubmissionID,
                        $field->formFieldID,
                        $form->gdriveSpreadsheetID,
                        $gsheetRowIndex,
                        $form->gdriveSpreadsheetID && $gsheetRowIndex ? $fileColOffset : null
                    );

                    $answerMap[$field->label] = '[File diterima, sedang diproses]';
                }

                $fileColOffset++;
            }

            // 12. Increment form submission counter
            $form->incrementSubmissionCount();

            // Submission succeeded — the autosaved draft is no longer needed
            TrFormDraft::clear($form->formID, auth()->id());

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
