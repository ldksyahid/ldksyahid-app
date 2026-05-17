<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsFormSettingTable extends Migration
{
    /**
     * Per-form key-value settings store.
     * Follows the same pattern as ms_setting but scoped to a form.
     *
     * Example keys: rate_limit_per_ip, rate_limit_window_minutes,
     *               allow_anonymous, send_confirmation_email, etc.
     */
    public function up(): void
    {
        if (Schema::hasTable('ms_form_setting')) {
            return;
        }

        Schema::create('ms_form_setting', function (Blueprint $table) {
            $table->bigIncrements('formSettingID');
            $table->unsignedBigInteger('formID')->index();

            $table->string('settingKey', 100)->index();
            $table->text('settingValue')->nullable();
            $table->enum('settingType', ['string', 'integer', 'boolean', 'json'])->default('string');
            $table->text('settingDescription')->nullable();

            $table->dateTime('createdDate');
            $table->dateTime('editedDate')->nullable();

            // One setting key per form
            $table->unique(['formID', 'settingKey']);

            $table->foreign('formID')
                  ->references('formID')
                  ->on('ms_form')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_form_setting');
    }
}
