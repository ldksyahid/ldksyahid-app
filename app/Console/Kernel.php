<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // Visitor analytics: re-aggregate page stats every hour
        $schedule->command('visitors:aggregate')->hourly();

        // Queue worker: runs every 10 minutes (hosting cron minimum interval).
        // --max-time=540 keeps the worker alive for 9 minutes so it fills the
        // full cron window, then exits cleanly before the next cron fires.
        //
        // --queue=whatsapp,email,default: queues are drained in this order
        // every pass, so WhatsApp jobs are never stuck behind an email
        // backlog. 'default' stays listed as a transition-safety net for any
        // job still labeled 'default' (see migration
        // 2026_07_28_000001_relabel_default_queue_to_email) — safe to drop
        // once /admin/job-queue-log confirms none remain.
        $schedule->command('queue:work --queue=whatsapp,email,default --max-time=540 --tries=3 --timeout=120')
                 ->everyTenMinutes()
                 ->withoutOverlapping();

        // Dynamic forms: close forms whose endDate has passed (runs every 5 minutes)
        // Skipped when QUEUE_CONNECTION=sync (development) because no forms have endDates set in dev
        $schedule->command('forms:close-expired')
                 ->everyFiveMinutes()
                 ->withoutOverlapping();

        // Celengan Syahid: mark QRIS donations as EXPIRED when expired_at has passed
        $schedule->command('donations:expire-qris')
                 ->everyTenMinutes()
                 ->withoutOverlapping();

        // WhatsApp (Fonnte): poll device connect/disconnect status for the
        // Job Queue Log dashboard badge. Same 10-minute floor as above (OS
        // cron minimum interval) — queue:work runs first in this schedule
        // and isn't backgrounded, so this typically executes in the last
        // ~1 minute of each cycle, same as donations:expire-qris above.
        $schedule->command('fonnte:check-device-status')
                 ->everyTenMinutes()
                 ->withoutOverlapping();

        // Auto-cleanup disabled — visitor data is kept indefinitely
        // $schedule->command('visitors:cleanup')->dailyAt('02:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected $commands = [
        Commands\CleanupVisitorLogs::class,
        Commands\AggregateVisitorStats::class,
        Commands\CloseExpiredForms::class,
        Commands\ExpireStaleQrisDonations::class,
        Commands\CheckFonnteDeviceStatus::class,
    ];
}
