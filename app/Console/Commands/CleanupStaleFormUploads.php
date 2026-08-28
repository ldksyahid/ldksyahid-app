<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupStaleFormUploads extends Command
{
    protected $signature   = 'forms:cleanup-stale-uploads {--days=3 : Delete temp uploads older than this many days}';
    protected $description = 'Delete leftover dynamic-form file uploads in storage/app/form-uploads-tmp that never made it to Google Drive';

    public function handle(): int
    {
        $days   = (int) $this->option('days');
        $cutoff = now()->subDays($days)->getTimestamp();
        $dir    = 'form-uploads-tmp';

        $deleted = 0;

        foreach (Storage::disk('local')->files($dir) as $path) {
            if (Storage::disk('local')->lastModified($path) < $cutoff) {
                Storage::disk('local')->delete($path);
                $deleted++;
            }
        }

        $this->info("Deleted {$deleted} stale form upload(s) older than {$days} days.");

        return self::SUCCESS;
    }
}
