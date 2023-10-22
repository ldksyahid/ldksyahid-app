<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLkGenerationTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('lk_generation')) {
            Schema::create('lk_generation', function (Blueprint $table) {
                $table->id();
                $table->string('year');
                $table->string('generationName');
                $table->timestamp('createdDate')->useCurrent();
                $table->timestamp('updatedDate')->useCurrent();
            });

            DB::table('lk_generation')->insert([
                ['year' => '1996', 'generationName' => '1996'],
                ['year' => '1997', 'generationName' => '1997'],
                ['year' => '1998', 'generationName' => '1998'],
                ['year' => '1999', 'generationName' => '1999'],
                ['year' => '2000', 'generationName' => 'Mentari'],
                ['year' => '2001', 'generationName' => '2001'],
                ['year' => '2002', 'generationName' => "Al-Ma'"],
                ['year' => '2003', 'generationName' => "2003"],
                ['year' => '2004', 'generationName' => "As-Syajaroh"],
                ['year' => '2005', 'generationName' => "An-Nahl"],
                ['year' => '2006', 'generationName' => "Al-Fath"],
                ['year' => '2007', 'generationName' => "Ash-Shaf"],
                ['year' => '2008', 'generationName' => "Al-Kahfi"],
                ['year' => '2009', 'generationName' => "Al-Ashr"],
                ['year' => '2010', 'generationName' => "An-Najm"],
                ['year' => '2011', 'generationName' => "Al-Qolam"],
                ['year' => '2012', 'generationName' => "Asy-Syams"],
                ['year' => '2013', 'generationName' => "Al-Anfal"],
                ['year' => '2014', 'generationName' => "An-Naml"],
                ['year' => '2015', 'generationName' => "Az-Zukhruf"],
                ['year' => '2016', 'generationName' => "Al-A'raaf"],
                ['year' => '2017', 'generationName' => "Al-Isra"],
                ['year' => '2018', 'generationName' => "Al-Muzzammil"],
                ['year' => '2019', 'generationName' => "Al-Qomar"],
                ['year' => '2020', 'generationName' => "Al-Furqan"],
                ['year' => '2021', 'generationName' => "Ali-Imran"],
                ['year' => '2022', 'generationName' => "Az-Zumar"],
                ['year' => '2023', 'generationName' => "2023"],
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('lk_generation');
    }
}
