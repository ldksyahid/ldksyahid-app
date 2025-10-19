<?php

use App\Models\MsCatalogBook;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableMsCatalogBook extends Migration
{
    public function up(): void
    {
        $tableName = MsCatalogBook::getTableName();

        if (Schema::hasTable($tableName)) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {

                $columnsToDrop = ['categoryName', 'language', 'readCount', 'downloadCount', 'rating'];
                foreach ($columnsToDrop as $col) {
                    if (Schema::hasColumn($tableName, $col)) {
                        $table->dropColumn($col);
                    }
                }

                if (!Schema::hasColumn($tableName, 'bookCategoryID')) {
                    $table->unsignedBigInteger('bookCategoryID')->nullable()->after('edition')->index();
                }
                if (!Schema::hasColumn($tableName, 'languageID')) {
                    $table->unsignedBigInteger('languageID')->nullable()->after('bookCategoryID')->index();
                }
                if (!Schema::hasColumn($tableName, 'authorTypeID')) {
                    $table->string('authorTypeID')->nullable()->after('languageID');
                }
                if (!Schema::hasColumn($tableName, 'availabilityTypeID')) {
                    $table->string('availabilityTypeID')->nullable()->after('authorTypeID');
                }
                if (!Schema::hasColumn($tableName, 'favoriteCount')) {
                    $table->integer('favoriteCount')->default(0)->after('pdfFileNameGdriveID');
                }
                if (!Schema::hasColumn($tableName, 'purchaseLink')) {
                    $table->string('purchaseLink')->nullable()->after('favoriteCount');
                }
                if (!Schema::hasColumn($tableName, 'borrowLink')) {
                    $table->string('borrowLink')->nullable()->after('purchaseLink');
                }
            });
        }
    }

    public function down(): void
    {
        $tableName = MsCatalogBook::getTableName();

        if (Schema::hasTable($tableName)) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {

                if (!Schema::hasColumn($tableName, 'categoryName')) {
                    $table->string('categoryName')->nullable()->index();
                }
                if (!Schema::hasColumn($tableName, 'language')) {
                    $table->string('language')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'readCount')) {
                    $table->integer('readCount')->default(0);
                }
                if (!Schema::hasColumn($tableName, 'downloadCount')) {
                    $table->integer('downloadCount')->default(0);
                }
                if (!Schema::hasColumn($tableName, 'rating')) {
                    $table->decimal('rating', 2, 1)->default(0.0);
                }

                $columnsToDrop = [
                    'bookCategoryID',
                    'languageID',
                    'favoriteCount',
                    'authorTypeID',
                    'purchaseLink',
                    'availabilityTypeID',
                    'borrowLink',
                ];

                foreach ($columnsToDrop as $col) {
                    if (Schema::hasColumn($tableName, $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
}
