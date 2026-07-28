<?php

namespace App\Jobs;

use App\Services\Fonnte;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Send a single WhatsApp message via Fonnte.
 * Dispatched from Fonnte::send() — never dispatch this directly from a
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

    // Plain constructor (no property promotion) — stays compatible with
    // PHP 7.4 on production, matching SendSingleMailJob's convention.
    public function __construct(string $target, string $message)
    {
        $this->target  = $target;
        $this->message = $message;
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
        // Fonnte device is disconnected (checked by CheckFonnteDeviceStatus) —
        // hold this job instead of forcing a guaranteed failure. This is a
        // soft release, NOT an exception, so it doesn't consume $maxExceptions
        // and doesn't clutter failed_jobs with failures that aren't really
        // about this message.
        if (Cache::get('fonnte_device_status') === 'disconnect') {
            $this->release(600); // retry in ~10 minutes, matching the status-check interval
            return;
        }

        Fonnte::deliver($this->target, $this->message);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("[SendSingleWhatsAppJob] Failed to send to {$this->target} after {$this->maxExceptions} exceptions: " . $exception->getMessage());
    }
}
