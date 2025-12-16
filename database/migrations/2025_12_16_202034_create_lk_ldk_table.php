<?php

use App\Models\LkLDK;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLkLdkTable extends Migration
{
    public function up(): void
    {
        $ldkTable = LkLDK::getTableName();

        if (!Schema::hasTable($ldkTable)) {
            Schema::create($ldkTable, function (Blueprint $table) {
                $table->bigIncrements('ldkID');
                $table->string('ldkTag')->unique();
                $table->string('ldkName')->unique();
                $table->string('logoGdriveID')->unique();
                $table->timestamp('createdDate')->nullable();
                $table->timestamp('editedDate')->nullable();
            });

            DB::table($ldkTable)->insert([
                [
                    'ldkTag'     => 'LDK Syahid',
                    'ldkName' => 'LDK Syahid',
                    'logoGdriveID' => '1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1',
                    'createdDate' => now(),
                    'editedDate'  => now(),
                ],
                [
                    'ldkTag'     => 'LDKSFAH',
                    'ldkName' => 'LDK Syahid Fakultas Adab dan Humaniora',
                    'logoGdriveID' => '1Fj4hZRy7SNQ1Kq72JvY4M557noiULg-i',
                    'createdDate' => now(),
                    'editedDate'  => now(),
                ],
                [
                    'ldkTag'     => 'LDKSFDI',
                    'ldkName' => 'LDK Syahid Fakultas Dirasat Islamiyah',
                    'logoGdriveID' => '1R-3mi9Jzw5vt3-VKVPic9BTvJeFkaikK',
                    'createdDate' => now(),
                    'editedDate'  => now(),
                ],
                [
                    'ldkTag'     => 'LDKSFDIKOM',
                    'ldkName' => 'LDK Syahid Fakultas Ilmu Dakwah dan Ilmu Komunikasi',
                    'logoGdriveID' => '1INzkD8YgOvf5_FVIXEnW40wUCsxJdepp',
                    'createdDate' => now(),
                    'editedDate'  => now(),
                ],
                [
                    'ldkTag'     => 'LDKSFKIK',
                    'ldkName' => 'LDK Syahid Fakultas Kedokteran dan Ilmu Kesehatan',
                    'logoGdriveID' => '1t_dDa8IDgpOnH85RvU67DV3W2CxhSetx',
                    'createdDate' => now(),
                    'editedDate'  => now(),
                ],
                [
                    'ldkTag'     => 'LDKSFISIP',
                    'ldkName' => 'LDK Syahid Fakultas Ilmu Sosial dan Ilmu Politik',
                    'logoGdriveID' => '1yU1Oj1qrFBanjcoj3ZhO1LPFOon7V92-',
                    'createdDate' => now(),
                    'editedDate'  => now(),
                ],
                [
                    'ldkTag'     => 'LDKSFITK',
                    'ldkName' => 'LDK Syahid Fakultas Ilmu Tarbiyah dan Keguruan',
                    'logoGdriveID' => '1u6mS175Q2Fbqd2k6CRNqKq0E3q5Sde1U',
                    'createdDate' => now(),
                    'editedDate'  => now(),
                ],
                [
                    'ldkTag'     => 'LDKSFSH',
                    'ldkName' => 'LDK Syahid Fakultas Syariah dan Hukum',
                    'logoGdriveID' => '1Iem3JZgYMXRitO1GOb9lTMVeMjiUQFUI',
                    'createdDate' => now(),
                    'editedDate'  => now(),
                ],
                [
                    'ldkTag'     => 'LDKSFST',
                    'ldkName' => 'LDK Syahid Fakultas Sains dan Teknologi',
                    'logoGdriveID' => '1HinEWSv90pL0MUZ1F0dAbyHNSmk2L-B5',
                    'createdDate' => now(),
                    'editedDate'  => now(),
                ],
                [
                    'ldkTag'     => 'LDKSFU',
                    'ldkName' => 'LDK Syahid Fakultas Ushuluddin',
                    'logoGdriveID' => '1zgyRIwgN-wnFHAquVyBvSuyhb4ZzpJ0R',
                    'createdDate' => now(),
                    'editedDate'  => now(),
                ],
                [
                    'ldkTag'     => 'LDKSFPsi',
                    'ldkName' => 'LDK Syahid Fakultas Psikologi',
                    'logoGdriveID' => '1sr4GI8TE-Z2Og4PBm3hqm1Bb38NryJ6U',
                    'createdDate' => now(),
                    'editedDate'  => now(),
                ],
            ]);

        }
    }

    public function down(): void
    {
        $ldkTable = LkLDK::getTableName();

        if (Schema::hasTable($ldkTable)) {
            Schema::dropIfExists($ldkTable);
        }
    }
}
