<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsKtaldksyahidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_ktaldksyahid', function (Blueprint $table) {
            $table->id();
            $table->string('fullName')->nullable();
            $table->string('gender')->nullable();
            $table->string('nim')->nullable();
            $table->integer('facultyID')->nullable();
            $table->integer('majorID')->nullable();
            $table->integer('generationID')->nullable();
            $table->string('memberNumber')->nullable();
            $table->string('slogan')->nullable();
            $table->longText('background')->nullable();
            $table->string('email')->nullable();
            $table->string('linkedIn')->nullable();
            $table->string('instagram')->nullable();
            $table->string('photo')->nullable();
            $table->string('linkProfile')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ms_ktaldksyahid');
    }
}
