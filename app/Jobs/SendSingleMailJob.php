<?php

namespace App\Jobs;

use App\Jobs\Middleware\WaitForMailDailyReset;
use App\Support\BrevoQuotaChecker;
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
        // Skip syntactically invalid addresses or domains that cannot receive mail.
        if (!EmailAddressValidator::isDeliverable($this->email)) {
            return;
        }

        // Brevo free plan silently accepts SMTP but drops emails once the 300/day
        // limit is hit — no exception thrown, so the job would complete "successfully"
        // while the email is lost. Check the API quota first and hold if exhausted.
        if (BrevoQuotaChecker::isLimitExceeded()) {
            $this->holdUntilReset();
            return;
        }

        try {
            Mail::to($this->email)->send($this->mailable);
        } catch (\Swift_TransportException $e) {
            if ($this->isDailyLimitError($e)) {
                // Fallback: SMTP error also signals the daily limit was hit.
                BrevoQuotaChecker::forget();
                $this->holdUntilReset();
                return;
            }

            // Other SMTP errors (connection lost, etc.) — normal retry with backoff.
            throw $e;
        }
    }

    /**
     * Mark the daily limit as active until midnight UTC (when Brevo resets)
     * and release this job with the same delay so it is retried after reset.
     */
    private function holdUntilReset(): void
    {
        $delay   = BrevoQuotaChecker::secondsUntilReset();
        $resetAt = now()->addSeconds($delay);

        // Cache until midnight UTC — WaitForMailDailyReset middleware reads this
        // and holds all subsequent jobs without re-checking the API.
        Cache::put('mail_daily_limit_exceeded', $resetAt->timestamp, $delay);

        $this->release($delay);
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
