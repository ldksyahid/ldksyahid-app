<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nomor_surat_counters', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('tahun')->unique();
            $table->unsignedInteger('urut_terakhir')->default(0);
            // Tanggal approval terakhir yang memakai urut_terakhir ini.
            // Dipakai buat nentuin apakah surat berikutnya butuh sub-nomor (.01, .02, ...)
            $table->date('tanggal_urut_terakhir')->nullable();
            $table->unsignedTinyInteger('sub_urut_hari_ini')->default(0);
            $table->timestamps();
        });

        // Seed dari data SuratLog yang sudah ada, supaya nomor urut tidak loncat
        // atau bentrok dengan nomor yang sudah pernah diterbitkan secara manual.
        $existing = DB::table('surat_logs')
            ->whereNotNull('approved_at')
            ->whereNotNull('nomor_surat')
            ->where('nomor_surat', '!=', '-')
            ->select('nomor_surat', 'approved_at')
            ->get();

        $maxPerTahun = [];
        foreach ($existing as $row) {
            if (!preg_match('/^(\d{3})(?:\.\d{2})?\//', $row->nomor_surat, $m)) {
                continue;
            }
            $tahun = \Illuminate\Support\Carbon::parse($row->approved_at)->year;
            $urut  = (int) $m[1];
            if (!isset($maxPerTahun[$tahun]) || $urut > $maxPerTahun[$tahun]) {
                $maxPerTahun[$tahun] = $urut;
            }
        }

        foreach ($maxPerTahun as $tahun => $urutTerakhir) {
            DB::table('nomor_surat_counters')->insert([
                'tahun'         => $tahun,
                'urut_terakhir' => $urutTerakhir,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('nomor_surat_counters');
    }
};