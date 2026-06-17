<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_logs', function (Blueprint $table) {
            // pending = menunggu persetujuan admin
            // approved = disetujui, PDF siap didownload
            // rejected = ditolak admin
            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending')
                  ->after('filename');

            $table->text('catatan_admin')->nullable()->after('status'); // alasan tolak / catatan approve
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()->after('catatan_admin');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
        });
    }

    public function down(): void
    {
        Schema::table('surat_logs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('approved_by');
            $table->dropColumn(['status', 'catatan_admin', 'approved_at']);
        });
    }
};