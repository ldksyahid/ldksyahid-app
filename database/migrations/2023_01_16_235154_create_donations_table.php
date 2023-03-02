<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('jumlah_donasi')->nullable();
            $table->string('nama_donatur')->nullable();
            $table->string('email_donatur')->nullable();
            $table->string('no_telp_donatur')->nullable();
            $table->string('pesan_donatur')->nullable();
            $table->longText('captcha')->nullable();
            $table->string('status')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->string('nama_merchant')->nullable();
            $table->string('biaya_admin')->nullable();
            $table->string('kode_unik')->nullable();
            $table->uuid('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
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
        Schema::dropIfExists('donations');
    }
}
