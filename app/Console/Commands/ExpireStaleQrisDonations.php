<?php

namespace App\Console\Commands;

use App\Models\CelsyahidAuditLog;
use App\Models\Donation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpireStaleQrisDonations extends Command
{
    protected $signature = 'donations:expire-qris
                            {--dry-run : Tampilkan berapa donasi yang akan di-expire tanpa mengubah data}';

    protected $description = 'Tandai donasi QRIS PENDING yang sudah melewati expired_at menjadi EXPIRED.';

    public function handle(): int
    {
        $isDryRun = $this->option('dry-run');

        $query = Donation::where('payment_status', 'PENDING')
            ->where('gateway', 'bisatopup')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<', now());

        if ($isDryRun) {
            $count = $query->count();
            $this->info("[DRY RUN] {$count} donasi QRIS akan di-expire.");
            return self::SUCCESS;
        }

        try {
            $expiredIds = $query->pluck('id')->toArray();
            $count      = count($expiredIds);

            if ($count === 0) {
                return self::SUCCESS;
            }

            Donation::whereIn('id', $expiredIds)->update(['payment_status' => 'EXPIRED']);

            Log::info('[ExpireStaleQrisDonations] expired ' . $count . ' donations', [
                'ids' => $expiredIds,
            ]);

            CelsyahidAuditLog::record(
                'auto_expire_qris',
                'donation',
                null,
                'Auto-expired ' . $count . ' QRIS donation(s) that passed expired_at: ' . implode(', ', array_slice($expiredIds, 0, 10)) . ($count > 10 ? '...' : '')
            );

            $this->info("Expired {$count} stale QRIS donation(s).");
        } catch (\Throwable $e) {
            Log::error('[ExpireStaleQrisDonations] failed: ' . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
