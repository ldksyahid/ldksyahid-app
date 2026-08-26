<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrFormDraftTable extends Migration
{
    /**
     * Stores a single in-progress (unsubmitted) draft per user per form, so
     * answers survive a refresh or a switch to another device. One row per
     * (formID, userID) — each autosave upserts into it. Deleted once the
     * form is actually submitted, or by the periodic cleanup command once
     * stale (see CleanupFormDrafts).
     */
    public function up(): void
    {
        if (Schema::hasTable('tr_form_draft')) {
            return;
        }

        Schema::create('tr_form_draft', function (Blueprint $table) {
            $table->bigIncrements('formDraftID');
            $table->unsignedBigInteger('formID')->index();
            $table->unsignedBigInteger('userID')->index();

            // Map of field_<formFieldID> => answer (text/array), file fields excluded
            $table->json('answers');

            $table->dateTime('createdDate');
            $table->dateTime('editedDate')->nullable();

            $table->unique(['formID', 'userID']);

            $table->foreign('formID')
                  ->references('formID')
                  ->on('ms_form')
                  ->onDelete('cascade');

            $table->foreign('userID')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_form_draft');
    }
}
