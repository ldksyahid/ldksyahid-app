<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Ubah tipe kolom tanggal di tr_job_queue dari UNIX timestamp (INT)
 * menjadi DATETIME agar terbaca seperti "2021-08-30 08:24:47".
 *
 * Tabel di-truncate terlebih dahulu karena job queue bersifat transient —
 * job yang masih pending harus di-dispatch ulang setelah migrasi ini.
 */
class ChangeJobQueueDatesToDatetime extends Migration
{
    public function up(): void
    {
        // Bersihkan job lama agar konversi tipe tidak merusak data
        DB::table('tr_job_queue')->truncate();

        DB::statement("
            ALTER TABLE tr_job_queue
                MODIFY reservedDate  DATETIME     NULL,
                MODIFY availableDate DATETIME NOT NULL,
                MODIFY createdDate   DATETIME NOT NULL
        ");
    }

    public function down(): void
    {
        DB::table('tr_job_queue')->truncate();

        DB::statement("
            ALTER TABLE tr_job_queue
                MODIFY reservedDate  INT UNSIGNED     NULL,
                MODIFY availableDate INT UNSIGNED NOT NULL,
                MODIFY createdDate   INT UNSIGNED NOT NULL
        ");
    }
}
