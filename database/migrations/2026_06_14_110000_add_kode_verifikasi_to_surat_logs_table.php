<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('surat_logs', function (Blueprint $table) {
            $table->uuid('kode_verifikasi')->unique()->after('nomor_surat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_logs', function (Blueprint $table) {
            $table->dropColumn('kode_verifikasi');
        });
    }
};