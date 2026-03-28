<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupVisitorLogs extends Command
{
    protected $signature   = 'visitors:cleanup {--days=90 : Delete records older than this many days}';
    protected $description = 'Delete raw visitor logs and daily unique records older than N days';

    public function handle(): int
    {
        $days = (int) $this->option('days');

        $cutoff = now()->subDays($days)->toDateTimeString();

        $logDeleted = DB::table('tr_visitor_log')
            ->where('visitedAt', '<', $cutoff)
            ->delete();

        $uniqueDeleted = DB::table('tr_visitor_daily_unique')
            ->where('visitDate', '<', now()->subDays($days)->toDateString())
            ->delete();

        $this->info("Deleted {$logDeleted} raw log records older than {$days} days.");
        $this->info("Deleted {$uniqueDeleted} daily unique records older than {$days} days.");
        $this->info('tr_visitor_page_stat is kept indefinitely.');

        return self::SUCCESS;
    }
}
