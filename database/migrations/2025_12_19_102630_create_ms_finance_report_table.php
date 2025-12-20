<?php

use App\Models\MsFinanceReport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsFinanceReportTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable(MsFinanceReport::getTableName())) {
            Schema::create(MsFinanceReport::getTableName(), function (Blueprint $table) {
                $table->bigIncrements('financeReportID');
                $table->string('fileName')->nullable()->index();
                $table->string('fileGdriveID')->nullable();
                $table->bigInteger('ldkID')->nullable()->index();
                $table->boolean('flagActive')->default(true)->index();
                $table->string('createdBy', 100)->nullable();
                $table->dateTime('createdDate')->nullable();
                $table->string('editedBy', 100)->nullable();
                $table->dateTime('editedDate')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable(MsFinanceReport::getTableName())) {
            Schema::dropIfExists(MsFinanceReport::getTableName());
        }
    }
}
