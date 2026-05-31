<?php

namespace App\Jobs;

use App\Mail\GeneratedEmailMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

/**
 * Dispatcher job: dispatches a SendSingleMailJob per email so each
 * send is independent — no duplicates from retry timeouts.
 *
 * Uses a cache lock to prevent duplicate dispatch on retry.
 * File attachments are cleaned up by CleanupStorageFilesJob.
 */
class SendGeneratedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 120;

    public function __construct(
        public string $subject,
        public string $body,
        public array  $emails,
        public array  $attachmentPaths = [],
    ) {}

    public function handle(): void
    {
        // Use subject + recipient count + timestamp hash as unique key
        $lockKey = 'generated_email_dispatched_' . md5($this->subject . count($this->emails) . json_encode($this->attachmentPaths));

        if (Cache::has($lockKey)) {
            return;
        }

        if (empty($this->emails)) {
            return;
        }

        $mailable = new GeneratedEmailMail($this->subject, $this->body, $this->attachmentPaths);

        foreach ($this->emails as $index => $email) {
            $delaySec = (int) floor($index / 10) * 60;

            SendSingleMailJob::dispatch($email, $mailable)
                ->delay(now()->addSeconds($delaySec));
        }

        Cache::put($lockKey, true, now()->addHours(24));

        if (!empty($this->attachmentPaths)) {
            CleanupStorageFilesJob::dispatch($this->attachmentPaths)
                ->delay(now()->addMinutes(30));
        }
    }
}
