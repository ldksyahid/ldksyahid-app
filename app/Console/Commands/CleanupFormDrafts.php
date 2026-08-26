<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupFormDrafts extends Command
{
    protected $signature   = 'forms:cleanup-drafts {--days=7 : Delete drafts not edited in this many days}';
    protected $description = 'Delete stale dynamic-form drafts (unsubmitted, abandoned autosaves)';

    public function handle(): int
    {
        $days   = (int) $this->option('days');
        $cutoff = now()->subDays($days)->toDateTimeString();

        $deleted = DB::table('tr_form_draft')
            ->where('editedDate', '<', $cutoff)
            ->delete();

        $this->info("Deleted {$deleted} form draft(s) not edited in over {$days} days.");

        return self::SUCCESS;
    }
}
