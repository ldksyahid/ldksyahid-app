<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('letters', function (Blueprint $table) {
        $table->id();
        $table->string('letter_number')->nullable()->unique(); // Kosong saat draft, terisi pas di-approve
        $table->string('type'); // SK, Undangan, Permohonan, dll
        $table->string('subject'); // Perihal Surat
        $table->longText('content'); // Isi surat (bisa pakai Summernote/TinyMCE)
        $table->string('attachment')->nullable(); // Lampiran (bisa string '1 Berkas' atau kosong)
        $table->string('destination')->nullable(); // Kepada Yth...
        
        // Status & Approval
        $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'sent'])->default('draft');
        $table->string('verification_hash')->unique(); // Slug unik buat QR Code (e.g., LDKS-8f7A9b)
        
        // Relasi ke User
        $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Yang bikin (Staf Kestari/Dept)
        $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null'); // Yang TTD (Ketua/Sekjen)
        
        $table->string('pdf_file_path')->nullable(); // Lokasi simpan file PDF kalau udah jadi
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('letters');
    }
}
