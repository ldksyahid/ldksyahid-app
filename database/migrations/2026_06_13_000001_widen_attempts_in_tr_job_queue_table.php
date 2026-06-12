<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WidenAttemptsInTrJobQueueTable extends Migration
{
    /**
     * `attempts` was unsignedTinyInteger (max 255). The custom queue driver
     * increments it on every reservation, so long-held jobs (e.g. emails held
     * during a Brevo daily-limit window) overflow at 256, which makes the
     * markJobAsReserved UPDATE crash and the worker loop on the same job.
     * Widen it to INT UNSIGNED so reservations never overflow.
     */
    public function up(): void
    {
        if (Schema::hasColumn('tr_job_queue', 'attempts')) {
            DB::statement('ALTER TABLE `tr_job_queue` MODIFY `attempts` INT UNSIGNED NOT NULL DEFAULT 0');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tr_job_queue', 'attempts')) {
            DB::statement('ALTER TABLE `tr_job_queue` MODIFY `attempts` TINYINT UNSIGNED NOT NULL');
        }
    }
}
