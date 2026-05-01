<?php

namespace App\Jobs;

use App\Jobs\Middleware\WaitForGmailDailyReset;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Send a single email to one recipient.
 * Dispatched by dispatcher jobs (SendNewsletterJob, etc.)
 * so each email is independent — no duplicates from retries.
 */
class SendSingleMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Unlimited pickup attempts, since the rate limiter and
     * WaitForGmailDailyReset often release the job without a real error.
     * Only actual exceptions are counted via $maxExceptions.
     */
    public int $tries = 0;

    /**
     * Number of real exceptions (not releases from rate limiter/middleware)
     * before the job is marked as permanently failed.
     */
    public int $maxExceptions = 5;

    /**
     * Timeout per single email send.
     */
    public int $timeout = 60;

    public function __construct(
        public string   $email,
        public Mailable $mailable,
    ) {}

    /**
     * Middleware stack:
     * 1. RateLimited  — limit to 10 emails/min to avoid SMTP throttling
     * 2. WaitForGmailDailyReset — hold job if Gmail daily limit is active
     */
    public function middleware(): array
    {
        return [
            new RateLimited('send-email'),
            new WaitForGmailDailyReset(),
        ];
    }

    /**
     * Backoff before retry on transient SMTP errors (not daily limit).
     * Daily limit is handled by WaitForGmailDailyReset middleware.
     */
    public function backoff(): array
    {
        return [30, 60];
    }

    public function handle(): void
    {
        try {
            Mail::to($this->email)->send($this->mailable);
        } catch (\Swift_TransportException $e) {
            if ($this->isGmailDailyLimitError($e)) {
                // Set 24-hour cache flag — middleware will hold other jobs
                $resetAt = now()->addHours(24);
                Cache::put('gmail_daily_limit_exceeded', $resetAt->timestamp, $resetAt);

                // Release this job until the limit resets
                $this->release((int) $resetAt->diffInSeconds(now()));
                return;
            }

            // Other SMTP errors (connection lost, etc.) — normal retry with backoff
            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("[SendSingleMailJob] Failed to send to {$this->email} after {$this->maxExceptions} exceptions: " . $exception->getMessage());
    }

    private function isGmailDailyLimitError(\Swift_TransportException $e): bool
    {
        return str_contains($e->getMessage(), '5.4.5')
            || str_contains($e->getMessage(), 'Daily user sending limit');
    }
}
