<?php

use App\Models\MsCatalogBook;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePdfFileNameColumnsFromMsCatalogBook extends Migration
{
    public function up(): void
    {
        Schema::table(MsCatalogBook::getTableName(), function (Blueprint $table) {
            if (Schema::hasColumn(MsCatalogBook::getTableName(), 'pdfFileName')) {
                $table->dropColumn('pdfFileName');
            }

            if (Schema::hasColumn(MsCatalogBook::getTableName(), 'pdfFileNameGdriveID')) {
                $table->dropColumn('pdfFileNameGdriveID');
            }
        });
    }

    public function down(): void
    {
        Schema::table(MsCatalogBook::getTableName(), function (Blueprint $table) {
            $table->string('pdfFileName', 255)->nullable()->after('coverImageGdriveID');
            $table->string('pdfFileNameGdriveID')->nullable()->after('pdfFileName');
        });
    }
}
