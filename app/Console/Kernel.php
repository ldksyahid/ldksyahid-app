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
        // withoutOverlapping(15): 15-minute lock, NOT the 24h default you get
        // from calling withoutOverlapping() bare. With the bare default, a
        // worker that gets killed abnormally (hosting resource limit, OOM,
        // etc.) without releasing its lock silently blocks every subsequent
        // run of this command for up to 24h — this happened in production
        // (queue sat completely untouched for ~11h). 15 minutes safely
        // exceeds --max-time=540 (9 min) so a healthy run is never mistaken
        // for overlap, while a stuck lock clears itself quickly instead of
        // blocking for most of a day.
        $schedule->command('queue:work --queue=whatsapp,email,default --max-time=540 --tries=3 --timeout=120')
                 ->everyTenMinutes()
                 ->withoutOverlapping(15);

        // Dynamic forms: close forms whose endDate has passed (runs every 5 minutes)
        // Skipped when QUEUE_CONNECTION=sync (development) because no forms have endDates set in dev
        $schedule->command('forms:close-expired')
                 ->everyFiveMinutes()
                 ->withoutOverlapping(10);

        // Celengan Syahid: mark QRIS donations as EXPIRED when expired_at has passed
        $schedule->command('donations:expire-qris')
                 ->everyTenMinutes()
                 ->withoutOverlapping(15);

        // WhatsApp (Kirimdev): poll this app's phone number status for the
        // Job Queue Log dashboard badge. Same 10-minute floor as above (OS
        // cron minimum interval) — queue:work runs first in this schedule
        // and isn't backgrounded, so this typically executes in the last
        // ~1 minute of each cycle, same as donations:expire-qris above.
        $schedule->command('kirimdev:check-account-status')
                 ->everyTenMinutes()
                 ->withoutOverlapping(15);

        // Letter Requests (Persuratan): auto-expire pending letter requests older than 7 days
        $schedule->command('letter:expire-stale')
                 ->dailyAt('00:05')
                 ->withoutOverlapping(15);

        // Auto-cleanup disabled — visitor data is kept indefinitely
        // $schedule->command('visitors:cleanup')->dailyAt('02:00');

        // Dynamic forms: delete draft autosaves abandoned for 7+ days
        $schedule->command('forms:cleanup-drafts')
                 ->dailyAt('00:15')
                 ->withoutOverlapping(15);

        // Dynamic forms: delete leftover local temp uploads (storage/app/form-uploads-tmp)
        // that never made it to Google Drive (job never ran/kept failing) — kept 3 days
        // to leave room for the queue's own retries/backoff before sweeping.
        $schedule->command('forms:cleanup-stale-uploads')
                 ->dailyAt('00:20')
                 ->withoutOverlapping(15);
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
        Commands\ExpireStaleLetterRequests::class,
        Commands\CheckKirimdevAccountStatus::class,
        Commands\SyncKirimdevTemplates::class,
        Commands\RegisterKirimdevWebhook::class,
        Commands\CleanupFormDrafts::class,
        Commands\CleanupStaleFormUploads::class,
    ];
}
