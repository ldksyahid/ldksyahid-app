<?php

use App\Constants\SettingKey\Key1;
use App\Constants\SettingKey\Key2;
use App\Models\MsSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SeedDeadlineSettings extends Migration
{
    public function up(): void
    {
        DB::table(MsSetting::getTableName())->updateOrInsert(
            ['key1' => Key1::DEADLINE, 'key2' => Key2::HostingServer],
            ['value1' => '2026-06-16', 'value2' => '840000']
        );

        DB::table(MsSetting::getTableName())->updateOrInsert(
            ['key1' => Key1::DEADLINE, 'key2' => Key2::RentDomain],
            ['value1' => '2027-03-05', 'value2' => '235000']
        );
    }

    public function down(): void
    {
        DB::table(MsSetting::getTableName())->where('key1', Key1::DEADLINE)->delete();
    }
}
