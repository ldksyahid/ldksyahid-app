<?php

namespace App\Jobs;

use App\Models\forms\TrFormFile;
use App\Services\DynamicFormGDriveService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Uploads a dynamic-form file-field submission to Google Drive in the
 * background. PublicFormController::submit() moves the upload out of PHP's
 * ephemeral request tmp file into storage/app/form-uploads-tmp/ (so it
 * survives past the request) and dispatches this job instead of calling
 * DynamicFormGDriveService synchronously — keeps the respondent's submit
 * request fast and resilient to a slow/flaky Drive API call.
 *
 * The Google Sheets cell already holds the "[file pending]" placeholder
 * written synchronously at submit time; this job overwrites it with the
 * real Drive link once the upload succeeds.
 */
class UploadFormFileToGDriveJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 90;

    public string $tempRelativePath;
    public string $originalFileName;
    public string $mimeType;
    public string $gdriveFolderID;
    public int    $submissionID;
    public int    $fieldID;
    public ?string $spreadsheetID;
    public ?int    $gsheetRowIndex;
    public ?int    $colIndex;

    // Plain constructor (no property promotion) — matches this app's other
    // queued jobs (e.g. SendSingleWhatsAppJob) for PHP 7.4 compatibility.
    public function __construct(
        string  $tempRelativePath,
        string  $originalFileName,
        string  $mimeType,
        string  $gdriveFolderID,
        int     $submissionID,
        int     $fieldID,
        ?string $spreadsheetID,
        ?int    $gsheetRowIndex,
        ?int    $colIndex
    ) {
        $this->tempRelativePath = $tempRelativePath;
        $this->originalFileName = $originalFileName;
        $this->mimeType         = $mimeType;
        $this->gdriveFolderID   = $gdriveFolderID;
        $this->submissionID     = $submissionID;
        $this->fieldID          = $fieldID;
        $this->spreadsheetID    = $spreadsheetID;
        $this->gsheetRowIndex   = $gsheetRowIndex;
        $this->colIndex         = $colIndex;
    }

    public function backoff(): array
    {
        return [15, 60, 180];
    }

    public function handle(): void
    {
        $absolutePath = storage_path('app/' . $this->tempRelativePath);

        if (!is_file($absolutePath)) {
            Log::error("[UploadFormFileToGDriveJob] Temp file missing, cannot upload: {$this->tempRelativePath}");
            return;
        }

        try {
            // $test=true lets UploadedFile wrap a plain local file instead of
            // requiring a genuine PHP upload tmp file (there is none here —
            // the request that received the upload has long since finished).
            $file = new UploadedFile($absolutePath, $this->originalFileName, $this->mimeType, null, true);

            $service = new DynamicFormGDriveService();
            $result  = $service->uploadFileToFieldFolder($this->gdriveFolderID, $file, $this->submissionID);

            TrFormFile::record(
                submissionID:     $this->submissionID,
                fieldID:          $this->fieldID,
                originalFileName: $result['originalFileName'],
                mimeType:         $result['mimeType'],
                fileSizeKB:       $result['fileSizeKB'],
                gdriveFileID:     $result['gdriveFileID'],
                gdriveFolderID:   $this->gdriveFolderID,
                gdriveFileUrl:    $result['gdriveFileUrl']
            );

            if ($this->spreadsheetID && $this->gsheetRowIndex && $this->colIndex !== null) {
                $service->updateCell($this->spreadsheetID, $this->gsheetRowIndex, $this->colIndex, $result['gdriveFileUrl']);
            }

            // Uploaded successfully — the local temp copy is no longer needed.
            @unlink($absolutePath);
        } catch (\Throwable $e) {
            // When running synchronously (e.g. local development with
            // QUEUE_CONNECTION=sync), catch external API failure so it
            // doesn't crash the respondent's submit request.
            if (config('queue.default') === 'sync') {
                Log::warning('[UploadFormFileToGDriveJob] Sync upload failed: ' . $e->getMessage());
                return;
            }

            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("[UploadFormFileToGDriveJob] Failed to upload \"{$this->originalFileName}\" (submission {$this->submissionID}) after {$this->tries} attempts: " . $exception->getMessage());
        // Leave the temp file in place for possible manual recovery —
        // forms:cleanup-stale-uploads removes it after 3 days regardless.
    }
}
