<?php

namespace App\Jobs;

use App\Jobs\Middleware\WaitForMailDailyReset;
use App\Support\EmailAddressValidator;
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
 *
 * Delivery uses the configured SMTP mailer (Brevo SMTP relay in production),
 * so the rendered email is identical to the previous SMTP setup.
 */
class SendSingleMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Unlimited pickup attempts, since the rate limiter and
     * WaitForMailDailyReset often release the job without a real error.
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

    public string $email;
    public Mailable $mailable;

    // Note: plain constructor (no PHP 8 property promotion) to stay
    // compatible with PHP 7.4 on production.
    public function __construct(string $email, Mailable $mailable)
    {
        $this->email    = $email;
        $this->mailable = $mailable;
    }

    /**
     * Middleware stack:
     * 1. RateLimited — limit to 10 emails/min to stay within the relay's rate.
     * 2. WaitForMailDailyReset — hold job if the daily sending limit is active.
     */
    public function middleware(): array
    {
        return [
            new RateLimited('send-email'),
            new WaitForMailDailyReset(),
        ];
    }

    /**
     * Backoff before retry on transient SMTP errors (not the daily limit).
     * The daily limit is handled by the WaitForMailDailyReset middleware.
     */
    public function backoff(): array
    {
        return [30, 60];
    }

    public function handle(): void
    {
        // Validate the recipient before sending: skip syntactically invalid
        // addresses or domains that cannot receive mail. These jobs complete
        // silently (no exception) so they are not retried.
        $reason = null;
        if (!EmailAddressValidator::isDeliverable($this->email, $reason)) {
            return;
        }

        try {
            Mail::to($this->email)->send($this->mailable);
        } catch (\Swift_TransportException $e) {
            if ($this->isDailyLimitError($e)) {
                // Set a 24-hour cache flag — middleware will hold other jobs.
                $resetAt = now()->addHours(24);
                Cache::put('mail_daily_limit_exceeded', $resetAt->timestamp, $resetAt);

                // Release this job until the limit resets.
                $this->release((int) $resetAt->diffInSeconds(now()));
                return;
            }

            // Other SMTP errors (connection lost, etc.) — normal retry with backoff.
            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("[SendSingleMailJob] Failed to send to {$this->email} after {$this->maxExceptions} exceptions: " . $exception->getMessage());
    }

    /**
     * Detect a "daily / period sending limit reached" response from the mail
     * relay. Gmail returns SMTP code 5.4.5; Brevo surfaces quota-related
     * wording. Matching errors are held (not failed) until the quota resets.
     *
     * Note: the Brevo substrings below are best-effort and can be tuned once
     * the exact over-quota message is observed in production logs.
     */
    private function isDailyLimitError(\Swift_TransportException $e): bool
    {
        $message = strtolower($e->getMessage());

        $needles = [
            '5.4.5',                    // Gmail daily limit
            'daily user sending limit', // Gmail
            'daily limit',              // generic / Brevo
            'sending limit',            // generic / Brevo
            'quota',                    // generic / Brevo
        ];

        foreach ($needles as $needle) {
            if (strpos($message, $needle) !== false) {
                return true;
            }
        }

        return false;
    }
}
