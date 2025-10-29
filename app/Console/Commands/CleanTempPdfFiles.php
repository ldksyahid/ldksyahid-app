<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanTempPdfFiles extends Command
{
    protected $signature = 'clean:temp-pdfs';
    protected $description = 'Clean temporary PDF files older than 12 hours';

    public function handle()
    {
        $tempDir = storage_path('app/temp/pdfs');

        if (!File::isDirectory($tempDir)) {
            $this->info('No temporary PDF directory found.');
            return;
        }

        $files = File::files($tempDir);
        $cleanedCount = 0;
        $cutoffTime = now()->subHours(12)->getTimestamp();

        foreach ($files as $file) {
            if (File::lastModified($file) < $cutoffTime) {
                File::delete($file);
                $cleanedCount++;
            }
        }

        $this->info("Cleaned {$cleanedCount} temporary PDF files.");
    }
}
