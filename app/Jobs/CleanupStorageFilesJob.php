<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Hapus file attachment dari storage setelah semua email selesai dikirim.
 * Di-dispatch dengan delay 30 menit agar semua SendSingleMailJob selesai lebih dulu.
 */
class CleanupStorageFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 1;
    public int $timeout = 60;

    public function __construct(public array $paths) {}

    public function handle(): void
    {
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
