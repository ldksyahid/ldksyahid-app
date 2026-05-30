<?php

use App\Constants\SettingKey\Key1;
use App\Constants\SettingKey\Key2;
use App\Models\MsSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SeedFinanceReportCpSettings extends Migration
{
    public function up(): void
    {
        // value1 = nama CP, value2 = nomor WhatsApp (format internasional, tanpa +)
        DB::table(MsSetting::getTableName())->updateOrInsert(
            ['key1' => Key1::LAPORAN_KEUANGAN, 'key2' => Key2::CpFinanceReportName],
            ['value1' => 'Nazwa Maulida Noor', 'value2' => null]
        );

        DB::table(MsSetting::getTableName())->updateOrInsert(
            ['key1' => Key1::LAPORAN_KEUANGAN, 'key2' => Key2::CpFinanceReportPhone],
            ['value1' => '6281389069943', 'value2' => null]
        );
    }

    public function down(): void
    {
        DB::table(MsSetting::getTableName())
            ->where('key1', Key1::LAPORAN_KEUANGAN)
            ->whereIn('key2', [Key2::CpFinanceReportName, Key2::CpFinanceReportPhone])
            ->delete();
    }
}
