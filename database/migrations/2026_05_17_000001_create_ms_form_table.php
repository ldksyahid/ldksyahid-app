<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsFormTable extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ms_form')) {
            return;
        }

        Schema::create('ms_form', function (Blueprint $table) {
            // Primary key
            $table->bigIncrements('formID');

            // Identity
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->text('description')->nullable();

            // Lifecycle status: draft → published → closed / archived
            $table->enum('status', ['draft', 'published', 'closed', 'archived'])
                  ->default('draft')
                  ->index();

            // Version counter — incremented on every structural change
            $table->unsignedInteger('version')->default(1);

            // Appearance
            $table->json('themeConfig')->nullable()->comment('Theme overrides (colors, fonts, etc.)');
            $table->string('headerImage', 500)->nullable();
            $table->string('headerImageGdriveID', 255)->nullable();

            // Submission rules
            $table->unsignedInteger('maxSubmission')->nullable()->comment('NULL = unlimited');
            $table->boolean('isMultipleSubmit')->default(false)->comment('Allow same user to submit more than once');
            $table->boolean('requireLogin')->default(false)->comment('Force authentication before submission');

            // Active period
            $table->dateTime('startDate')->nullable()->comment('NULL = active immediately when published');
            $table->dateTime('endDate')->nullable()->comment('NULL = no expiry');

            // Post-submission UX
            $table->text('confirmationMessage')->nullable()->comment('Shown to user after successful submission');
            $table->string('redirectUrl', 500)->nullable()->comment('Redirect to this URL instead of showing message');

            // Notifications
            $table->json('notifyEmails')->nullable()->comment('Array of emails to notify on new submission');

            // Google Drive integration — populated by DynamicFormGDriveService::setupFormFolder()
            $table->json('collaboratorEmails')->nullable()->comment('Emails granted Editor access to the GDrive folder');
            $table->string('gdriveFolderID', 255)->nullable()->comment('GDrive folder ID: dynamic_form/{Form Title}/');
            $table->string('gdriveSpreadsheetID', 255)->nullable()->comment('Google Spreadsheet file ID inside the form folder');
            $table->string('gdriveSpreadsheetUrl', 500)->nullable()->comment('Direct URL to the Google Spreadsheet');
            $table->string('gdriveAttachmentsFolderID', 255)->nullable()->comment('GDrive folder ID: .../attachments/');
            $table->string('gdriveAttachmentsFolderUrl', 500)->nullable()->comment('Direct URL to the attachments folder');

            // Denormalized counter for fast display (avoids COUNT query on tr_form_submission)
            $table->unsignedInteger('totalSubmission')->default(0);

            // Soft delete flag (follows existing project pattern)
            $table->boolean('flagActive')->default(true)->index();

            // Audit columns
            $table->string('createdBy', 100)->comment('Email or name of the admin who created the form');
            $table->dateTime('createdDate');
            $table->string('editedBy', 100)->nullable();
            $table->dateTime('editedDate')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_form');
    }
}
