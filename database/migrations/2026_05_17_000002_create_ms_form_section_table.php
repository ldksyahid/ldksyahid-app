<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsFormSectionTable extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ms_form_section')) {
            return;
        }

        Schema::create('ms_form_section', function (Blueprint $table) {
            $table->bigIncrements('formSectionID');
            $table->unsignedBigInteger('formID')->index();

            $table->string('title', 255);
            $table->text('description')->nullable();

            // Display order within the form
            $table->unsignedInteger('sortOrder')->default(0);

            $table->boolean('flagActive')->default(true);
            $table->dateTime('createdDate');
            $table->dateTime('editedDate')->nullable();

            $table->foreign('formID')
                  ->references('formID')
                  ->on('ms_form')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_form_section');
    }
}
