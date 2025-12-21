<?php

use App\Models\LkReport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLkReportTable extends Migration
{
    public function up(): void
    {
        $reportTable = LkReport::getTableName();

        if (!Schema::hasTable($reportTable)) {
            Schema::create($reportTable, function (Blueprint $table) {
                $table->bigIncrements('reportID');
                $table->string('reportName');
                $table->string('node');
                $table->text('description')->nullable();
                $table->string('iconGdriveID')->nullable();
                $table->timestamp('createdDate')->nullable();
                $table->timestamp('editedDate')->nullable();
            });

            DB::table($reportTable)->insert([
                [
                    'reportName' => 'Laporan Keuangan',
                    'node' => '/laporan-keuangan',
                    'description' => 'Laporan Keuangan LDK Syahid merupakan pencatatan pemasukan dan pengeluaran transaksi keuangan sesuai dengan realisasi Program Kerja dan Non Program Kerja untuk menjaga transparansi dan akuntabilitas keuangan, baik di LDK Syahid tingkat Pusat maupun Fakultas.',
                    'iconGdriveID' => '1Z8nd1FOuN2JiQ76YuRHkHOmtrPukvO4V',
                    'createdDate' => now(),
                    'editedDate' => now(),
                ]
            ]);
        }
    }

    public function down(): void
    {
        $reportTable = LkReport::getTableName();

        if (Schema::hasTable($reportTable)) {
            Schema::dropIfExists($reportTable);
        }
    }
}
