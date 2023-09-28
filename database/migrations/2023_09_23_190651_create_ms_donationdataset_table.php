<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsDonationdatasetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_donationdataset', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('jumlah_donasi')->nullable();
            $table->string('nama_donatur')->nullable();
            $table->string('email_donatur')->nullable();
            $table->string('usia')->nullable();
            $table->string('domisili')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('no_telp_donatur')->nullable();
            $table->string('pesan_donatur')->nullable();
            $table->longText('captcha')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->string('nama_merchant')->nullable();
            $table->string('biaya_admin')->nullable();
            $table->string('kode_unik')->nullable();
            $table->uuid('campaign_id');
            $table->string('doc_no')->nullable();
            $table->string('payment_status')->nullable();
            $table->text('payment_link')->nullable();
            $table->bigInteger('total_tagihan')->nullable();
            $table->timestamps();
            $table->id('idInc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ms_donationdataset');
    }
}
