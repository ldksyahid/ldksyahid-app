<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrFormFileTable extends Migration
{
    /**
     * Tracks every file uploaded through a form submission.
     * Files are stored exclusively in Google Drive — no local filesystem storage.
     * Each file lives in: dynamic_form/{Form Title}/attachments/{Field Label}/
     */
    public function up(): void
    {
        if (Schema::hasTable('tr_form_file')) {
            return;
        }

        Schema::create('tr_form_file', function (Blueprint $table) {
            $table->bigIncrements('formFileID');
            $table->unsignedBigInteger('formSubmissionID')->index();
            $table->unsignedBigInteger('formFieldID')->index();

            // Original file metadata
            $table->string('originalFileName', 255)->comment('Name of the file as uploaded by the user');
            $table->string('mimeType', 100)->nullable();
            $table->unsignedInteger('fileSizeKB')->nullable()->comment('File size in kilobytes');

            // Google Drive references — NOT NULL because files are GDrive-only
            $table->string('gdriveFileID', 255)->comment('Google Drive file ID');
            $table->string('gdriveFolderID', 255)->comment('GDrive field subfolder ID where the file lives');
            $table->string('gdriveFileUrl', 500)->nullable()->comment('Direct view URL for the file on GDrive');

            $table->dateTime('createdDate');

            $table->foreign('formSubmissionID')
                  ->references('formSubmissionID')
                  ->on('tr_form_submission')
                  ->onDelete('cascade');

            $table->foreign('formFieldID')
                  ->references('formFieldID')
                  ->on('ms_form_field')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_form_file');
    }
}
