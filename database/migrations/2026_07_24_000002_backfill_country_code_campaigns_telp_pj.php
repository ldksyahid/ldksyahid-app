<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * The admin Campaign form's "PIC Contact" field used to hardcode a "+62"
 * prefix and store only the bare local number in telp_pj (e.g. "87713671510").
 * A country dropdown was added so telp_pj now stores the full number
 * including its country code with no leading zero or "+" (e.g. "62877...").
 *
 * Every existing row predates the dropdown and is Indonesia-only, so this
 * backfills them to the new format by prepending "62".
 */
class BackfillCountryCodeCampaignsTelpPj extends Migration
{
    public function up(): void
    {
        DB::table('campaigns')
            ->whereNotNull('telp_pj')
            ->where('telp_pj', '!=', '')
            ->where('telp_pj', 'not like', '62%')
            ->update(['telp_pj' => DB::raw("CONCAT('62', telp_pj)")]);
    }

    public function down(): void
    {
        DB::table('campaigns')
            ->whereNotNull('telp_pj')
            ->where('telp_pj', 'like', '62%')
            ->update(['telp_pj' => DB::raw("SUBSTRING(telp_pj, 3)")]);
    }
}
