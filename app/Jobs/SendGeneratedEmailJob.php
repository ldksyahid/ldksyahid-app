<?php

namespace App\Jobs;

use App\Mail\GeneratedEmailMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Dispatcher job: dispatch SendSingleMailJob per email sehingga setiap
 * pengiriman berdiri sendiri — tidak ada duplicate akibat retry timeout.
 *
 * File attachment di-cleanup oleh CleanupStorageFilesJob yang di-dispatch
 * dengan delay 30 menit, memberi waktu semua individual send jobs selesai.
 */
class SendGeneratedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 1;
    public int $timeout = 120;

    public function __construct(
        public string $subject,
        public string $body,
        public array  $emails,
        public array  $attachmentPaths = [],
    ) {}

    public function handle(): void
    {
        if (empty($this->emails)) {
            Log::info("[SendGeneratedEmailJob] No recipients, job finished.");
            return;
        }

        $mailable = new GeneratedEmailMail($this->subject, $this->body, $this->attachmentPaths);

        foreach ($this->emails as $email) {
            SendSingleMailJob::dispatch($email, $mailable);
        }

        Log::info("[SendGeneratedEmailJob] Dispatched " . count($this->emails) . " individual send jobs. Subject: \"{$this->subject}\".");

        if (!empty($this->attachmentPaths)) {
            CleanupStorageFilesJob::dispatch($this->attachmentPaths)
                ->delay(now()->addMinutes(30));
        }
    }
}
