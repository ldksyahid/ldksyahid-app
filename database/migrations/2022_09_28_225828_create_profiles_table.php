<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('namapanggilan')->nullable();
            $table->string('sifat')->nullable();
            $table->string('tentangdiri')->nullable();
            $table->string('universitas')->nullable();
            $table->string('nim')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('programstudi')->nullable();
            $table->string('forkat')->nullable();
            $table->string('nomoranggota')->nullable();
            $table->string('akuninstagram')->nullable();
            $table->string('akunlinkedin')->nullable();
            $table->string('mottohidup')->nullable();
            $table->string('profilepicture')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
