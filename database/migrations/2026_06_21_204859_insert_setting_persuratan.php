<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\MsSetting;

return new class extends Migration
{
    public function up(): void
    {
        \App\Models\MsSetting::firstOrCreate(
            ['key1' => 'Persuratan', 'key2' => 'Kontak Sekjen'],
            ['value1' => '6285776923137', 'value2' => 'M. Zhaffar Rabbany']
        );

        \App\Models\MsSetting::firstOrCreate(
            ['key1' => 'Persuratan', 'key2' => 'Kontak Kestari'],
            ['value1' => '6285819353387', 'value2' => 'M. Fiqhan Fajar']
        );
    }
    
    public function down(): void
    {
        // Menghapus data kalau sewaktu-waktu migration di-rollback
        MsSetting::where('key1', 'Persuratan')->delete();
    }
};