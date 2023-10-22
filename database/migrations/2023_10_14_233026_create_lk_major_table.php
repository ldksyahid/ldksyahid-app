<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLkMajorTable extends Migration
{
    public function up()
    {
        Schema::create('lk_major', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('facultyID');
            $table->string('majorName');
            $table->timestamp('createdDate')->useCurrent();
            $table->timestamp('updatedDate')->useCurrent();
        });
        DB::table('lk_major')->insert([
            ['facultyID' => 1, 'majorName' => 'Pendidikan Agama Islam'],
            ['facultyID' => 1, 'majorName' => 'Pendidikan Bahasa Arab'],
            ['facultyID' => 1, 'majorName' => 'Pendidikan Bahasa Inggris'],
            ['facultyID' => 1, 'majorName' => 'Pendidikan IPS'],
            ['facultyID' => 1, 'majorName' => 'Pendidikan Matematika'],
            ['facultyID' => 1, 'majorName' => 'Pendidikan Biologi'],
            ['facultyID' => 1, 'majorName' => 'Pendidikan Fisika'],
            ['facultyID' => 1, 'majorName' => 'Pendidikan Kimia'],
            ['facultyID' => 1, 'majorName' => 'Manajemen Pendidikan'],
            ['facultyID' => 1, 'majorName' => 'Pendidikan Bahasa dan Sastra Indonesia'],
            ['facultyID' => 1, 'majorName' => 'Pendidikan Guru MI/SD'],
            ['facultyID' => 1, 'majorName' => 'Pendidikan Islam Anak Usia Dini (PIAUD)'],
            ['facultyID' => 2, 'majorName' => 'Bahasa dan Sastra Arab'],
            ['facultyID' => 2, 'majorName' => 'Sastra Inggris'],
            ['facultyID' => 2, 'majorName' => 'Sejarah dan Kebudayaan Islam'],
            ['facultyID' => 2, 'majorName' => 'Tarjamah (Bahasa Arab)'],
            ['facultyID' => 2, 'majorName' => 'Ilmu Perpustakaan'],
            ['facultyID' => 3, 'majorName' => 'Studi Agama Agama'],
            ['facultyID' => 3, 'majorName' => 'Ilmu Al-Quran dan Tafsir'],
            ['facultyID' => 3, 'majorName' => 'Ilmu Hadis'],
            ['facultyID' => 3, 'majorName' => 'Aqidah dan Filsafat Islam'],
            ['facultyID' => 3, 'majorName' => 'Ilmu Tasawuf'],
            ['facultyID' => 4, 'majorName' => 'Perbandingan Mazhab'],
            ['facultyID' => 4, 'majorName' => 'Hukum Keluarga Islam (Akhwal Syakhsiyyah)'],
            ['facultyID' => 4, 'majorName' => 'Hukum Tata Negara (Siyasah)'],
            ['facultyID' => 4, 'majorName' => 'Hukum Pidana Islam (Jinayah)'],
            ['facultyID' => 4, 'majorName' => 'Hukum Ekonomi Syariah (Muamalat)'],
            ['facultyID' => 4, 'majorName' => 'Ilmu Hukum'],
            ['facultyID' => 5, 'majorName' => 'Komunikasi dan Penyiaran Islam'],
            ['facultyID' => 5, 'majorName' => 'Bimbingan Penyuluhan Islam'],
            ['facultyID' => 5, 'majorName' => 'Manajeman Dakwah'],
            ['facultyID' => 5, 'majorName' => 'Pengembangan Masyarakat Islam'],
            ['facultyID' => 5, 'majorName' => 'Kesejahteraan Sosial'],
            ['facultyID' => 5, 'majorName' => 'Jurnalistik'],
            ['facultyID' => 6, 'majorName' => 'Dirasat Islamiyah'],
            ['facultyID' => 7, 'majorName' => 'Psikologi'],
            ['facultyID' => 8, 'majorName' => 'Manajemen'],
            ['facultyID' => 8, 'majorName' => 'Akuntansi'],
            ['facultyID' => 8, 'majorName' => 'Ekonomi Pembangunan'],
            ['facultyID' => 8, 'majorName' => 'Perbankan Syariah'],
            ['facultyID' => 8, 'majorName' => 'Ekonomi Syariah'],
            ['facultyID' => 9, 'majorName' => 'Teknik Informatika'],
            ['facultyID' => 9, 'majorName' => 'Agribisnis'],
            ['facultyID' => 9, 'majorName' => 'Sistem Informasi'],
            ['facultyID' => 9, 'majorName' => 'Matematika'],
            ['facultyID' => 9, 'majorName' => 'Biologi'],
            ['facultyID' => 9, 'majorName' => 'Kimia'],
            ['facultyID' => 9, 'majorName' => 'Fisika'],
            ['facultyID' => 9, 'majorName' => 'Teknik Pertambangan'],
            ['facultyID' => 10, 'majorName' => 'Kesehatan Masyarakat'],
            ['facultyID' => 10, 'majorName' => 'Farmasi'],
            ['facultyID' => 10, 'majorName' => 'Ilmu Keperawatan'],
            ['facultyID' => 11, 'majorName' => 'Sosiologi'],
            ['facultyID' => 11, 'majorName' => 'Ilmu Politik'],
            ['facultyID' => 11, 'majorName' => 'Ilmu Hubungan Internasional'],
            ['facultyID' => 12, 'majorName' => 'Kedokteran'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('lk_major');
    }
}
