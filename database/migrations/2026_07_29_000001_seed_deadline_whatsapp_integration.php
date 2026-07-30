<?php

use App\Constants\SettingKey\Key1;
use App\Constants\SettingKey\Key2;
use App\Models\MsSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SeedDeadlineWhatsappIntegration extends Migration
{
    public function up(): void
    {
        DB::table(MsSetting::getTableName())->updateOrInsert(
            ['key1' => Key1::DEADLINE, 'key2' => Key2::WhatsappIntegration],
            ['value1' => '2026-08-29', 'value2' => '25000']
        );
    }

    public function down(): void
    {
        DB::table(MsSetting::getTableName())
            ->where('key1', Key1::DEADLINE)
            ->where('key2', Key2::WhatsappIntegration)
            ->delete();
    }
}
