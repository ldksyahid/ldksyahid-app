<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapFormCollaboratorTable extends Migration
{
    /**
     * Maps registered admin users to forms as collaborators.
     * Collaborators can view submissions and manage the form (depending on role).
     *
     * Note: External collaborators (non-registered users) are stored in
     * ms_form.collaboratorEmails (JSON) and given GDrive Editor access only.
     * This table handles in-app access for registered admin users.
     */
    public function up(): void
    {
        if (Schema::hasTable('map_form_collaborator')) {
            return;
        }

        Schema::create('map_form_collaborator', function (Blueprint $table) {
            $table->bigIncrements('formCollaboratorID');
            $table->unsignedBigInteger('formID')->index();
            $table->unsignedBigInteger('userID')->index();

            // In-app permission level for this collaborator
            $table->enum('role', ['viewer', 'editor', 'manager'])->default('viewer')
                  ->comment('viewer=read only, editor=manage submissions, manager=edit form structure');

            $table->dateTime('addedDate');

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
        Schema::dropIfExists('map_form_collaborator');
    }
}
