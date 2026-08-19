<?php

namespace App\Console\Commands;

use App\Models\SuratLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpireStaleLetterRequests extends Command
{
    protected $signature = 'letter:expire-stale
                            {--days=7 : Jumlah hari sebelum pengajuan surat dinyatakan kadaluarsa}
                            {--dry-run : Tampilkan permohonan surat yang akan di-expire tanpa mengubah data}';

    protected $description = 'Tandai pengajuan surat PENDING yang sudah melewati batas waktu (default 7 hari) menjadi EXPIRED.';

    public function handle(): int
    {
        $days     = (int) $this->option('days');
        $isDryRun = $this->option('dry-run');

        $cutoff = now()->subDays($days);

        $query = SuratLog::where('status', 'pending')
            ->where('created_at', '<', $cutoff);

        if ($isDryRun) {
            $count = $query->count();
            $this->info("[DRY RUN] {$count} pengajuan surat pending lebih dari {$days} hari akan di-expire.");
            return self::SUCCESS;
        }

        try {
            $staleIds = $query->pluck('id')->toArray();
            $count    = count($staleIds);

            if ($count === 0) {
                $this->info('Tidak ada pengajuan surat pending yang kadaluarsa.');
                return self::SUCCESS;
            }

            SuratLog::whereIn('id', $staleIds)->update([
                'status'        => 'expired',
                'catatan_admin' => 'Kadaluarsa otomatis setelah melewati batas waktu ' . $days . ' hari.',
            ]);

            Log::info('[ExpireStaleLetterRequests] expired ' . $count . ' letter requests', [
                'ids' => $staleIds,
            ]);

            $this->info("Berhasil mengubah status {$count} pengajuan surat menjadi EXPIRED.");
        } catch (\Throwable $e) {
            Log::error('[ExpireStaleLetterRequests] failed: ' . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
