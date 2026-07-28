<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * SendSingleMailJob used to be dispatched with no explicit queue name, so
 * every existing row in tr_job_queue is labeled 'default'. Now that it sets
 * public string $queue = 'email' (see SendSingleMailJob.php), relabel the
 * existing rows so they match — this only changes the 'queue' column, not
 * payload/attempts/availableDate/reservedDate, so in-flight or retrying
 * jobs are unaffected.
 */
class RelabelDefaultQueueToEmail extends Migration
{
    public function up(): void
    {
        DB::table('tr_job_queue')
            ->where('queue', 'default')
            ->update(['queue' => 'email']);
    }

    public function down(): void
    {
        DB::table('tr_job_queue')
            ->where('queue', 'email')
            ->update(['queue' => 'default']);
    }
}
