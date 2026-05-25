<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrFormAuditLogTable extends Migration
{
    /**
     * Tracks all admin actions on forms:
     * create, update, publish, close, archive, delete, restore, etc.
     *
     * The payload JSON captures the before/after state or action details.
     */
    public function up(): void
    {
        if (Schema::hasTable('tr_form_audit_log')) {
            return;
        }

        Schema::create('tr_form_audit_log', function (Blueprint $table) {
            $table->bigIncrements('formAuditLogID');

            // formID can be null if the form was hard-deleted
            $table->unsignedBigInteger('formID')->nullable()->index();
            $table->unsignedBigInteger('userID')->nullable()->index()
                  ->comment('ID of the admin who performed the action (null = system)');

            $table->string('action', 50)->index()
                  ->comment('create, update, publish, close, archive, delete, restore, add_field, remove_field, etc.');

            $table->json('payload')->nullable()
                  ->comment('Action-specific data: {before: {...}, after: {...}} or {description: "..."}');

            $table->string('ipAddress', 45)->nullable();

            $table->dateTime('createdDate')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_form_audit_log');
    }
}
