<?php

namespace App\Console\Commands;

use App\Models\forms\MsForm;
use App\Models\forms\TrFormAuditLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CloseExpiredForms extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'forms:close-expired
                            {--dry-run : Show how many forms would be closed without actually closing them}';

    /**
     * The console command description.
     */
    protected $description = 'Close all published forms whose endDate has passed.';

    public function handle(): int
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $count = MsForm::where('status', 'published')
                           ->where('flagActive', true)
                           ->whereNotNull('endDate')
                           ->where('endDate', '<', now())
                           ->count();

            $this->info("[DRY RUN] {$count} form(s) would be closed.");
            return self::SUCCESS;
        }

        try {
            $count = MsForm::closeExpiredForms();

            if ($count > 0) {
                // Record audit log for each closed form
                TrFormAuditLog::record(
                    formID:    null, // bulk operation — no single formID
                    userID:    null,
                    action:    TrFormAuditLog::ACTION_CLOSE,
                    payload:   ['reason' => 'expired', 'count' => $count],
                    ipAddress: null
                );
            }

            $this->info("Closed {$count} expired form(s).");

        } catch (\Throwable $e) {
            Log::error('[CloseExpiredForms] Failed: ' . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
