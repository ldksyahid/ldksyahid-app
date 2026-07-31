<?php

namespace App\Jobs;

use App\Services\Kirimdev;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Send a single WhatsApp message via Kirimdev.
 * Dispatched from WhatsApp::send() — never dispatch this directly from a
 * controller, so every WhatsApp message (regardless of type) stays behind
 * the same rate limiter.
 */
class SendSingleWhatsAppJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Unlimited pickup attempts — the rate limiter releases this job
     * repeatedly under normal operation, that is not a real failure.
     */
    public int $tries = 0;

    /**
     * Number of real exceptions (not rate-limiter releases) before the job
     * is marked as permanently failed.
     */
    public int $maxExceptions = 5;

    public int $timeout = 30;

    public string $target;
    public string $message;

    // Name of the Kirimdev/Meta Message Template matching this message, and
    // the ordered values for its {{1}}, {{2}}... placeholders. See
    // App\Services\WhatsApp's sendXxx() methods for how each template's
    // params are built. Null for ad-hoc admin notices with no fixed
    // template (see WhatsApp::send()) — sent as freeform text instead.
    public ?string $templateName;
    public array $templateParams;

    // Ordered payload strings for the template's quick-reply BUTTONS
    // component (empty = template has no buttons). See Kirimdev::deliver().
    public array $buttonPayloads;

    // Plain constructor (no property promotion) — stays compatible with
    // PHP 7.4 on production, matching SendSingleMailJob's convention.
    public function __construct(string $target, string $message, ?string $templateName = null, array $templateParams = [], array $buttonPayloads = [])
    {
        $this->target         = $target;
        $this->message        = $message;
        $this->templateName   = $templateName;
        $this->templateParams = $templateParams;
        $this->buttonPayloads = $buttonPayloads;
    }

    public function middleware(): array
    {
        return [new RateLimited('send-whatsapp')];
    }

    public function backoff(): array
    {
        return [15, 30, 60];
    }

    public function handle(): void
    {
        // Kirimdev account is disconnected (checked by
        // kirimdev:check-account-status) — hold this job instead of forcing
        // a guaranteed failure. This is a soft release, NOT an exception, so
        // it doesn't consume $maxExceptions and doesn't clutter failed_jobs
        // with failures that aren't really about this message.
        if (Cache::get('kirimdev_account_status') === 'disconnected') {
            $this->release(600); // retry in ~10 minutes, matching the status-check interval
            return;
        }

        if ($this->templateName === null) {
            Kirimdev::deliverText($this->target, $this->message);
        } else {
            Kirimdev::deliver($this->target, $this->templateName, $this->templateParams, $this->buttonPayloads);
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("[SendSingleWhatsAppJob] Failed to send to {$this->target} after {$this->maxExceptions} exceptions: " . $exception->getMessage());
    }
}
