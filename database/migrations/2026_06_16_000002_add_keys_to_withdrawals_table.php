<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddKeysToWithdrawalsTable extends Migration
{
    public function up(): void
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            // Primary key
            if (!$this->hasPrimaryKey('withdrawals')) {
                $table->primary('id');
            }

            // Unique on reff_id
            if (!$this->hasIndex('withdrawals', 'withdrawals_reff_id_unique')) {
                $table->unique('reff_id');
            }

            // Index on campaign_id (FK lookup)
            if (!$this->hasIndex('withdrawals', 'withdrawals_campaign_id_foreign')) {
                $table->index('campaign_id');
            }

            // Index on created_by (FK lookup)
            if (!$this->hasIndex('withdrawals', 'withdrawals_created_by_foreign')) {
                $table->index('created_by');
            }

            // Index on status (frequent filter)
            if (!$this->hasIndex('withdrawals', 'withdrawals_status_index')) {
                $table->index('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropPrimary('id');
            $table->dropUnique('withdrawals_reff_id_unique');
            $table->dropIndex('withdrawals_campaign_id_foreign');
            $table->dropIndex('withdrawals_created_by_foreign');
            $table->dropIndex('withdrawals_status_index');
        });
    }

    private function hasPrimaryKey(string $table): bool
    {
        $result = DB::select("SHOW KEYS FROM `{$table}` WHERE Key_name = 'PRIMARY'");
        return !empty($result);
    }

    private function hasIndex(string $table, string $indexName): bool
    {
        $result = DB::select(
            "SHOW KEYS FROM `{$table}` WHERE Key_name = ?",
            [$indexName]
        );
        return !empty($result);
    }
}
