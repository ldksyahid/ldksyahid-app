<?php

use App\Constants\SettingKey\Key1;
use App\Constants\SettingKey\Key2;
use App\Models\MsSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMsSettingTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable(MsSetting::getTableName())) {
            Schema::create(MsSetting::getTableName(), function (Blueprint $table) {
                $table->string('key1', 191)->index();
                $table->string('key2', 191)->index();
                $table->string('value1', 1000)->nullable();
                $table->string('value2', 1000)->nullable();

                $table->unique(['key1', 'key2']);
            });

            // Insert default row
            DB::table(MsSetting::getTableName())->updateOrInsert(
                [
                    'key1' => Key1::LAYANAN,
                    'key2' => Key2::CpShortlink,
                ],
                [
                    'value1' => '+62895394755672',
                    'value2' => null,
                ]
            );
        }
    }

    public function down(): void
    {
        if (Schema::hasTable(MsSetting::getTableName())) {
            Schema::dropIfExists(MsSetting::getTableName());
        }
    }
}
