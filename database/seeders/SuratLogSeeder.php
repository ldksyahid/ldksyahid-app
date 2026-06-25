<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratLog;
use Illuminate\Support\Str;

class SuratLogSeeder extends Seeder
{
    public function run()
    {
        // Contoh data surat untuk demo
        SuratLog::create([
            'user_id' => 3, // Sesuaikan dengan ID user di CreateUsersSeeder
            'jenis_surat' => 'izin-orang-tua',
            'label' => 'Surat Izin Orang Tua',
            'nomor_surat' => '001/LDK/VI/2026',
            'kode_verifikasi' => 'c3591513-9b6a-4280-98e9-fc47b8b05e64', // Kode untuk test verifikasi
            'data' => ['nama_acara' => 'Mabit', 'hari_tanggal' => '2026-06-25'],
            'status' => 'approved',
            'approved_at' => now(),
        ]);
    }
}