<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Hapus file attachment dari storage setelah semua email selesai dikirim.
 * Di-dispatch dengan delay 30 menit agar semua SendSingleMailJob selesai lebih dulu.
 *
 * Jika Gmail daily limit aktif, job akan reschedule dirinya sendiri
 * agar attachment tidak terhapus sebelum semua email terkirim.
 */
class CleanupStorageFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 60;

    public function __construct(public array $paths) {}

    public function handle(): void
    {
        // If daily limit is active, reschedule — emails are still waiting
        $resetAt = Cache::get('gmail_daily_limit_exceeded');
        if ($resetAt) {
            $delaySeconds = max(60, $resetAt - now()->timestamp) + 1800; // after reset + 30 min buffer
            self::dispatch($this->paths)->delay(now()->addSeconds($delaySeconds));
            Log::info("[CleanupStorageFilesJob] Gmail daily limit active, rescheduled cleanup in {$delaySeconds}s.");
            return;
        }

        $deleted = 0;

        foreach ($this->paths as $path) {
            if (Storage::exists($path)) {
                Storage::delete($path);
                $deleted++;
            }
        }

        Log::info("[CleanupStorageFilesJob] Deleted {$deleted} attachment file(s).");
    }
}
