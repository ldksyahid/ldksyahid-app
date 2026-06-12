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
        $schedule->command('queue:work --max-time=540 --tries=3 --timeout=120')
                 ->everyTenMinutes()
                 ->withoutOverlapping();

        // Dynamic forms: close forms whose endDate has passed (runs every 5 minutes)
        // Skipped when QUEUE_CONNECTION=sync (development) because no forms have endDates set in dev
        $schedule->command('forms:close-expired')
                 ->everyFiveMinutes()
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
    ];
}
