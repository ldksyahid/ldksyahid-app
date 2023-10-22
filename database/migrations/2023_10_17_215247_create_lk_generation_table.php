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
                ['year' => '2018', 'generationName' => 'Al-Muzammil'],
                ['year' => '2019', 'generationName' => 'Al-Qomar'],
                ['year' => '2020', 'generationName' => 'Al-Imran'],
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('lk_generation');
    }
}
