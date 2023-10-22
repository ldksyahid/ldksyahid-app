<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLkFacultyTable extends Migration
{
    public function up()
    {
        Schema::create('lk_faculty', function (Blueprint $table) {
            $table->id();
            $table->string('facultyName');
            $table->timestamp('createdDate')->useCurrent();
            $table->timestamp('updatedDate')->useCurrent();
        });
        DB::table('lk_faculty')->insert([
            ['facultyName' => 'Ilmu Tarbiyah dan Keguruan'],
            ['facultyName' => 'Adab dan Humaniora'],
            ['facultyName' => 'Ushuluddin'],
            ['facultyName' => 'Syariah dan Hukum'],
            ['facultyName' => 'Ilmu Dakwah dan Ilmu Komunikasi'],
            ['facultyName' => 'Dirasat Islamiyah'],
            ['facultyName' => 'Psikologi'],
            ['facultyName' => 'Ekonomi dan Bisnis'],
            ['facultyName' => 'Sains dan Teknologi'],
            ['facultyName' => 'Ilmu Kesehatan'],
            ['facultyName' => 'Ilmu Sosial dan Ilmu Politik'],
            ['facultyName' => 'Kedokteran'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('lk_faculty');
    }
}
