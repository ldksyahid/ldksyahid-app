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
        Schema::create('surat_counters', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_surat');     // contoh: surat-rekomendasi
            $table->string('periode', 6);      // format Ym, contoh: 202606
            $table->unsignedInteger('counter')->default(0);
            $table->timestamps();

            $table->unique(['jenis_surat', 'periode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_counters');
    }
};