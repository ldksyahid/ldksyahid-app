<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * Delete attachment files from storage after all emails have been sent.
 * Dispatched with a 30-minute delay so every SendSingleMailJob finishes first.
 *
 * If the mail daily limit is active, the job reschedules itself so the
 * attachments are not deleted before all emails have been delivered.
 */
class CleanupStorageFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 60;

    public array $paths;

    // Note: plain constructor (no PHP 8 property promotion) to stay
    // compatible with PHP 7.4 on production.
    public function __construct(array $paths)
    {
        $this->paths = $paths;
    }

    public function handle(): void
    {
        // If the daily limit is active, reschedule — emails are still waiting.
        $resetAt = Cache::get('mail_daily_limit_exceeded');
        if ($resetAt) {
            $delaySeconds = max(60, $resetAt - now()->timestamp) + 1800; // after reset + 30 min buffer
            self::dispatch($this->paths)->delay(now()->addSeconds($delaySeconds));
            return;
        }

        $deleted = 0;

        foreach ($this->paths as $path) {
            if (Storage::exists($path)) {
                Storage::delete($path);
                $deleted++;
            }
        }

    }
}
