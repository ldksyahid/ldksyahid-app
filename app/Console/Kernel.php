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

        // Queue worker: proses semua pending jobs setiap menit
        $schedule->command('queue:work --stop-when-empty --tries=3 --timeout=120')
                 ->everyMinute()
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
        Commands\RunDonationClassMachine::class,
        Commands\CleanupVisitorLogs::class,
        Commands\AggregateVisitorStats::class,
    ];
}
