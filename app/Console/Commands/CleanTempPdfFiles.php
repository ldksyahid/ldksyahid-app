<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CleanTempPdfFiles extends Command
{
    protected $signature = 'clean:temp-pdfs';
    protected $description = 'Clean temporary PDF files older than 12 hours';

    public function handle()
    {
        $tempPath = storage_path('app/temp/pdfs');

        if (!file_exists($tempPath)) {
            $this->info('Temporary directory does not exist.');
            return;
        }

        $files = File::files($tempPath);
        $deletedCount = 0;
        $threshold = now()->subHours(12)->getTimestamp();

        foreach ($files as $file) {
            if (filemtime($file) < $threshold) {
                File::delete($file);
                $deletedCount++;
            }
        }

        $this->info("Deleted {$deletedCount} temporary PDF files.");

        Log::info("Temporary PDF cleanup: {$deletedCount} files deleted.");
    }
}
