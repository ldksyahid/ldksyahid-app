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
            
            // Relational Keys
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Document Identifiers
            $table->string('jenis_surat');
            $table->string('label');
            $table->string('nomor_surat')->default('-');
            $table->uuid('kode_verifikasi')->unique();
            
            // Dynamic Form Payload (Crucial: Using JSON to avoid making too many columns)
            $table->json('data');
            
            // Output & Status
            $table->string('filename')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            // Approval Tracking
            $table->text('catatan_admin')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            
            // Default Timestamps (created_at, updated_at)
            $table->timestamps();
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