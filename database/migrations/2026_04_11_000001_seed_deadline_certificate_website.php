<?php

use App\Constants\SettingKey\Key1;
use App\Constants\SettingKey\Key2;
use App\Models\MsSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SeedDeadlineCertificateWebsite extends Migration
{
    public function up(): void
    {
        DB::table(MsSetting::getTableName())->updateOrInsert(
            ['key1' => Key1::DEADLINE, 'key2' => Key2::CertificateWebsite],
            ['value1' => '2026-03-31', 'value2' => null]
        );
    }

    public function down(): void
    {
        DB::table(MsSetting::getTableName())
            ->where('key1', Key1::DEADLINE)
            ->where('key2', Key2::CertificateWebsite)
            ->delete();
    }
}
