<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AggregateVisitorStats extends Command
{
    protected $signature   = 'visitors:aggregate {--date= : Date to aggregate (Y-m-d), defaults to today}';
    protected $description = 'Re-compute tr_visitor_page_stat from raw tr_visitor_log for a given date';

    public function handle(): int
    {
        $date = $this->option('date') ?: now()->toDateString();

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $this->error('Invalid date format. Use Y-m-d.');
            return self::FAILURE;
        }

        $this->info("Aggregating visitor stats for {$date}...");

        // Pull aggregated data from raw logs for the given date
        $rows = DB::table('tr_visitor_log')
            ->selectRaw('
                path,
                COUNT(*) as totalHits,
                COUNT(DISTINCT ipHash) as uniqueVisitors,
                SUM(CASE WHEN deviceType = "mobile"  THEN 1 ELSE 0 END) as mobileHits,
                SUM(CASE WHEN deviceType = "desktop" THEN 1 ELSE 0 END) as desktopHits,
                SUM(CASE WHEN deviceType = "tablet"  THEN 1 ELSE 0 END) as tabletHits,
                SUM(CASE WHEN deviceType = "bot"     THEN 1 ELSE 0 END) as botHits
            ')
            ->whereDate('visitedAt', $date)
            ->groupByRaw('path')
            ->get();

        $upserted = 0;
        foreach ($rows as $row) {
            DB::statement("
                INSERT INTO tr_visitor_page_stat
                    (statDate, path, totalHits, uniqueVisitors, mobileHits, desktopHits, tabletHits, botHits, createdDate, updatedDate)
                VALUES
                    (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
                ON DUPLICATE KEY UPDATE
                    totalHits      = VALUES(totalHits),
                    uniqueVisitors = VALUES(uniqueVisitors),
                    mobileHits     = VALUES(mobileHits),
                    desktopHits    = VALUES(desktopHits),
                    tabletHits     = VALUES(tabletHits),
                    botHits        = VALUES(botHits),
                    updatedDate    = NOW()
            ", [
                $date,
                $row->path,
                $row->totalHits,
                $row->uniqueVisitors,
                $row->mobileHits,
                $row->desktopHits,
                $row->tabletHits,
                $row->botHits,
            ]);
            $upserted++;
        }

        $this->info("Done. Upserted {$upserted} page stat records for {$date}.");

        return self::SUCCESS;
    }
}
