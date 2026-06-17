<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('jenis_surat');     // contoh: surat-rekomendasi
            $table->string('label');           // contoh: Surat Rekomendasi
            $table->string('nomor_surat');     // contoh: 001/SR-e/LDK-SYAHID/VI/2026
            $table->json('data');              // snapshot input form saat generate
            $table->string('filename');        // nama file pdf yang di-download
            $table->timestamps();

            $table->index(['jenis_surat', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_logs');
    }
};