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
                ['bookCategoryName' => 'Teknologi'],
                ['bookCategoryName' => 'Kesehatan'],
                ['bookCategoryName' => 'Psikologi'],
                ['bookCategoryName' => 'Ekonomi'],
                ['bookCategoryName' => 'Bisnis & Manajemen'],
                ['bookCategoryName' => 'Komputer & Informatika'],
                ['bookCategoryName' => 'Hukum'],
                ['bookCategoryName' => 'Politik & Pemerintahan'],
                ['bookCategoryName' => 'Filsafat'],
                ['bookCategoryName' => 'Seni & Desain'],
                ['bookCategoryName' => 'Bahasa & Linguistik'],
                ['bookCategoryName' => 'Komunikasi & Media'],
                ['bookCategoryName' => 'Pertanian'],
                ['bookCategoryName' => 'Peternakan'],
                ['bookCategoryName' => 'Teknik Sipil'],
                ['bookCategoryName' => 'Teknik Mesin'],
                ['bookCategoryName' => 'Teknik Elektro'],
                ['bookCategoryName' => 'Teknik Industri'],
                ['bookCategoryName' => 'Teknik Kimia'],
                ['bookCategoryName' => 'Teknik Lingkungan'],
                ['bookCategoryName' => 'Matematika'],
                ['bookCategoryName' => 'Fisika'],
                ['bookCategoryName' => 'Kimia'],
                ['bookCategoryName' => 'Biologi'],
                ['bookCategoryName' => 'Astronomi'],
                ['bookCategoryName' => 'Geografi'],
                ['bookCategoryName' => 'Arsitektur'],
                ['bookCategoryName' => 'Sosial & Budaya'],
                ['bookCategoryName' => 'Keluarga & Parenting'],
                ['bookCategoryName' => 'Motivasi & Pengembangan Diri'],
                ['bookCategoryName' => 'Travel & Pariwisata'],
                ['bookCategoryName' => 'Kuliner'],
                ['bookCategoryName' => 'Fiksi'],
                ['bookCategoryName' => 'Non-Fiksi'],
                ['bookCategoryName' => 'Puisi'],
                ['bookCategoryName' => 'Cerpen'],
                ['bookCategoryName' => 'Novel'],
                ['bookCategoryName' => 'Komik & Manga'],
                ['bookCategoryName' => 'Ensiklopedia'],
                ['bookCategoryName' => 'Majalah & Jurnal'],
                ['bookCategoryName' => 'Biografi'],
                ['bookCategoryName' => 'Autobiografi'],
                ['bookCategoryName' => 'Anak-anak'],
                ['bookCategoryName' => 'Remaja'],
                ['bookCategoryName' => 'Umum'],
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
