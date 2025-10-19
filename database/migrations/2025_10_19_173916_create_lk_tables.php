<?php

use App\Models\LkBookCategory;
use App\Models\LkLanguage;
use App\Models\LkAuthorType;
use App\Models\LkAvailabilityType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLkTables extends Migration
{
    public function up(): void
    {
        $bookCategoryTable = LkBookCategory::getTableName();
        if (!Schema::hasTable($bookCategoryTable)) {
            Schema::create($bookCategoryTable, function (Blueprint $table) {
                $table->bigIncrements('bookCategoryID');
                $table->string('bookCategoryName')->unique();
            });

            DB::table($bookCategoryTable)->insert([
                ['bookCategoryName' => 'Agama'],
                ['bookCategoryName' => 'Pendidikan'],
                ['bookCategoryName' => 'Sains'],
                ['bookCategoryName' => 'Sejarah'],
                ['bookCategoryName' => 'Sastra'],
            ]);
        }

        $languageTable = LkLanguage::getTableName();
        if (!Schema::hasTable($languageTable)) {
            Schema::create($languageTable, function (Blueprint $table) {
                $table->bigIncrements('languageID');
                $table->string('languageName')->unique();
            });

            DB::table($languageTable)->insert([
                ['languageName' => 'Indonesia'],
                ['languageName' => 'English'],
                ['languageName' => 'Arabic'],
            ]);
        }

        $authorTypeTable = LkAuthorType::getTableName();
        if (!Schema::hasTable($authorTypeTable)) {
            Schema::create($authorTypeTable, function (Blueprint $table) {
                $table->bigIncrements('authorTypeID');
                $table->string('authorTypeName')->unique();
            });

            DB::table($authorTypeTable)->insert([
                ['authorTypeName' => 'Kader'],
                ['authorTypeName' => 'Non Kader'],
            ]);
        }

        $availabilityTable = LkAvailabilityType::getTableName();
        if (!Schema::hasTable($availabilityTable)) {
            Schema::create($availabilityTable, function (Blueprint $table) {
                $table->bigIncrements('availabilityTypeID');
                $table->string('availabilityTypeName')->unique();
            });

            DB::table($availabilityTable)->insert([
                ['availabilityTypeName' => 'Available Full PDF'],
                ['availabilityTypeName' => 'Available Preview Only PDF'],
                ['availabilityTypeName' => 'Available at Mahar'],
            ]);
        }
    }

    public function down(): void
    {
        $tables = [
            LkBookCategory::getTableName(),
            LkLanguage::getTableName(),
            LkAuthorType::getTableName(),
            LkAvailabilityType::getTableName(),
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::dropIfExists($table);
            }
        }
    }
}
