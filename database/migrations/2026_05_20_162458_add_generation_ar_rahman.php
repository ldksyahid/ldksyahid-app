<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddGenerationArRahman extends Migration
{
    public function up()
    {
        DB::table('lk_generation')
            ->where('year', '2023')
            ->update(['generationName' => 'An-Nur']);

        DB::table('lk_generation')->insert([
            ['year' => '2024', 'generationName' => 'Al-Hadid'],
            ['year' => '2025', 'generationName' => 'Ar-Rahman'],
        ]);
    }

    public function down()
    {
        DB::table('lk_generation')
            ->where('year', '2023')
            ->update(['generationName' => '2023']);

        DB::table('lk_generation')
            ->whereIn('year', ['2024', '2025'])
            ->delete();
    }
}