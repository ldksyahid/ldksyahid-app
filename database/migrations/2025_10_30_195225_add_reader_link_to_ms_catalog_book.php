<?php

use App\Models\MsCatalogBook;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReaderLinkToMsCatalogBook extends Migration
{
    public function up(): void
    {
        Schema::table(MsCatalogBook::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(MsCatalogBook::getTableName(), 'readerLink')) {
                $table->text('readerLink')->nullable()->after('coverImageGdriveID');
            }
        });
    }

    public function down(): void
    {
        Schema::table(MsCatalogBook::getTableName(), function (Blueprint $table) {
            if (Schema::hasColumn(MsCatalogBook::getTableName(), 'readerLink')) {
                $table->dropColumn('readerLink');
            }
        });
    }
}
