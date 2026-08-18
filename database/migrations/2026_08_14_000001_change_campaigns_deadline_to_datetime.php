<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * campaigns.deadline was DATE-only — admins couldn't set a specific time of
 * day, so every deadline implicitly meant "end of that day" with no way to
 * express e.g. "17:00". MySQL's DATE -> DATETIME MODIFY is non-destructive:
 * every existing value is kept as-is with 00:00:00 appended as the time
 * portion, so no data is lost — raw SQL is used here (not
 * Schema::table()->date(...)->change()) since this app doesn't have
 * doctrine/dbal installed, which Laravel's column-change builder requires.
 */
class ChangeCampaignsDeadlineToDatetime extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE campaigns MODIFY deadline DATETIME NULL');
    }

    public function down(): void
    {
        // Reverts to DATE — any time-of-day portion set after this
        // migration ran is truncated back to midnight, same as it would
        // have been before this migration existed.
        DB::statement('ALTER TABLE campaigns MODIFY deadline DATE NULL');
    }
}
