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
 * Dispatcher job: dispatches a SendSingleMailJob per email so each
 * send is independent — no duplicates from retry timeouts.
 *
 * File attachments are cleaned up by CleanupStorageFilesJob, dispatched
 * with a 30-minute delay to allow all individual send jobs to complete.
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

        foreach ($this->emails as $index => $email) {
            $delaySec = (int) floor($index / 10) * 60;

            SendSingleMailJob::dispatch($email, $mailable)
                ->delay(now()->addSeconds($delaySec));
        }

        Log::info("[SendGeneratedEmailJob] Dispatched " . count($this->emails) . " individual send jobs. Subject: \"{$this->subject}\".");

        if (!empty($this->attachmentPaths)) {
            CleanupStorageFilesJob::dispatch($this->attachmentPaths)
                ->delay(now()->addMinutes(30));
        }
    }
}
