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
            $table->uuid('id')->primary();
            $table->string('logo_pj')->nullable();
            $table->string('nama_pj')->nullable();
            $table->string('telp_pj')->nullable();
            $table->string('link_pj')->nullable();
            $table->string('poster')->nullable();
            $table->string('kategori')->nullable();
            $table->string('judul')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->longText('cerita')->nullable();
            $table->longText('kabar_terbaru')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('target_biaya')->nullable();
            $table->date('deadline')->nullable();
            $table->string('link')->unique()->nullable();
            $table->string('status')->nullable();
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
