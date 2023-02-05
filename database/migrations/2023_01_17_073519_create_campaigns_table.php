<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('logo_pj')->nullable();
            $table->string('nama_pj')->nullable();
            $table->string('telp_pj')->nullable();
            $table->string('poster')->nullable();
            $table->string('kategori')->nullable();
            $table->string('judul')->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->longText('cerita')->nullable();
            $table->longText('kabar_terbaru')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('target_biaya')->nullable();
            $table->date('deadline')->nullable();
            $table->string('link')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('donations_id');
            $table->foreign('donations_id')->references('id')->on('donations')->onDelete('cascade');
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
        Schema::dropIfExists('campaigns');
    }
}
