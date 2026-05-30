<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrFormSubmissionTable extends Migration
{
    /**
     * Stores METADATA only — actual answers are written to Google Sheets.
     *
     * The gsheetRowIndex references the exact row in the Google Spreadsheet
     * so we can cross-reference the DB record with the sheet row if needed.
     */
    public function up(): void
    {
        if (Schema::hasTable('tr_form_submission')) {
            return;
        }

        Schema::create('tr_form_submission', function (Blueprint $table) {
            $table->bigIncrements('formSubmissionID');
            $table->unsignedBigInteger('formID')->index();

            // Respondent identity — email is always present (system-enforced field)
            $table->string('respondentEmail', 255)->index();
            $table->string('respondentName', 255)->nullable();
            $table->string('respondentPhone', 30)->nullable();

            // Cross-reference to Google Sheets row
            $table->unsignedInteger('gsheetRowIndex')->nullable()
                  ->comment('Row number in the Google Spreadsheet (1-based, including header)');

            // Request metadata for anti-spam and audit
            $table->string('ipAddress', 45)->nullable()->index()
                  ->comment('IPv4 or IPv6 address');
            $table->text('userAgent')->nullable();

            // Spam / validity flag — auto-set to true, may be flipped by anti-spam check
            $table->boolean('flagValid')->default(true)->index();

            // Snapshot of form version at the time of submission
            $table->unsignedInteger('formVersion')->default(1);

            $table->dateTime('submittedAt')->index();

            $table->foreign('formID')
                  ->references('formID')
                  ->on('ms_form')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_form_submission');
    }
}
