<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrCelsyahidAuditLogTable extends Migration
{
    /**
     * Append-only audit trail of admin actions on Celengan Syahid
     * campaigns and donations (create/update/delete/bulk-delete).
     */
    public function up(): void
    {
        if (Schema::hasTable('tr_celsyahid_audit_log')) {
            return;
        }

        Schema::create('tr_celsyahid_audit_log', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id')->nullable()->index()
                  ->comment('Admin who performed the action (null = system)');

            $table->string('action', 50)->index()
                  ->comment('e.g. campaign.create, campaign.update, donation.delete');

            // Campaign/Donation primary keys are UUID strings
            $table->string('entity_type', 30)->nullable()->comment('campaign | donation');
            $table->string('entity_id', 64)->nullable()->index();

            $table->string('description', 255)->nullable();
            $table->string('ip_address', 45)->nullable();

            $table->dateTime('created_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_celsyahid_audit_log');
    }
}
