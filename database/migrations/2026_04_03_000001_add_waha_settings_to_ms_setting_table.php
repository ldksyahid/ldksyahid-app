<?php

use App\Constants\SettingKey\Key1;
use App\Constants\SettingKey\Key2;
use App\Models\MsSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddWahaSettingsToMsSettingTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable(MsSetting::getTableName())) {
            return;
        }

        // Nomor tujuan notifikasi WhatsApp untuk request shortlink baru
        DB::table(MsSetting::getTableName())->updateOrInsert(
            [
                'key1' => Key1::WAHA,
                'key2' => Key2::NotifShortlinkTo,
            ],
            [
                'value1' => '62895394755672',
                'value2' => null,
            ]
        );
    }

    public function down(): void
    {
        if (!Schema::hasTable(MsSetting::getTableName())) {
            return;
        }

        DB::table(MsSetting::getTableName())->where([
            'key1' => Key1::WAHA,
            'key2' => Key2::NotifShortlinkTo,
        ])->delete();
    }
}
