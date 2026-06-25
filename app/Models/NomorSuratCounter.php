<?php
// ============================================================
// FILE 1: app/Models/NomorSuratCounter.php
// Perubahan: tambah method syncManualNomor()
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class NomorSuratCounter extends Model
{
    protected $table = 'nomor_surat_counters';

    protected $fillable = [
        'tahun',
        'urut_terakhir',
        'tanggal_urut_terakhir',
        'sub_urut_hari_ini',
    ];

    protected $casts = [
        'tahun'                 => 'integer',
        'urut_terakhir'         => 'integer',
        'tanggal_urut_terakhir' => 'date',
        'sub_urut_hari_ini'     => 'integer',
    ];

    public static function nextNomor(int $tahun, ?Carbon $tanggal = null): array
    {
        $tanggal = $tanggal ?? now();

        return DB::transaction(function () use ($tahun, $tanggal) {
            $counter = static::lockForUpdate()->firstOrCreate(
                ['tahun' => $tahun],
                ['urut_terakhir' => 0, 'sub_urut_hari_ini' => 0]
            );

            $isSameDay = $counter->tanggal_urut_terakhir
                && $counter->tanggal_urut_terakhir->isSameDay($tanggal);

            if ($isSameDay) {
                $counter->sub_urut_hari_ini += 1;
                $urut = $counter->urut_terakhir;
                $sub  = '.' . str_pad((string) $counter->sub_urut_hari_ini, 2, '0', STR_PAD_LEFT);
            } else {
                $counter->urut_terakhir += 1;
                $counter->sub_urut_hari_ini = 0;
                $urut = $counter->urut_terakhir;
                $sub  = '';
            }

            $counter->tanggal_urut_terakhir = $tanggal->toDateString();
            $counter->save();

            return [
                'urut' => str_pad((string) $urut, 3, '0', STR_PAD_LEFT),
                'sub'  => $sub,
            ];
        });
    }

    public static function syncManualNomor(int $tahun, int $urut, ?int $sub, Carbon $tanggal): bool
    {
        return DB::transaction(function () use ($tahun, $urut, $sub, $tanggal) {
            $counter = static::lockForUpdate()->firstOrCreate(
                ['tahun' => $tahun],
                ['urut_terakhir' => 0, 'sub_urut_hari_ini' => 0]
            );

            if ($urut < $counter->urut_terakhir) {
                return false;
            }

            if ($urut === $counter->urut_terakhir) {
                $isSameDay = $counter->tanggal_urut_terakhir
                    && $counter->tanggal_urut_terakhir->isSameDay($tanggal);

                if (!$isSameDay) {
                    return false;
                }

                if ($sub === null || $sub <= $counter->sub_urut_hari_ini) {
                    return false;
                }

                $counter->sub_urut_hari_ini = $sub;
            } else {
                $counter->urut_terakhir     = $urut;
                $counter->sub_urut_hari_ini = $sub ?? 0;
            }

            $counter->tanggal_urut_terakhir = $tanggal->toDateString();
            $counter->save();

            return true;
        });
    }
}