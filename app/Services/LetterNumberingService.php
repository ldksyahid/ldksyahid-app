<?php

namespace App\Services;

use App\Models\NomorSuratCounter;
use App\Models\SuratLog;
use App\Support\LetterRegistry;

class LetterNumberingService
{
    public const NOMOR_MANUAL_PATTERN = '/^\d{3}(\.\d{2})?\/[A-Za-z.\-]+-(i|e)\/[A-Za-z.\-]+\/LDK SYAHID\/\d{1,2}\/\d{4}$/';

    public function approve(SuratLog $log, ?string $nomorManual, ?string $catatanAdmin, int $adminId, string $kodeBidang = 'KST'): array
    {
        if ($nomorManual) {
            if (!str_contains($nomorManual, '/')) {
                $kodeJenis = $this->resolveKodeJenis($log);
                $sifat     = $this->resolveSifat($log);
                $bulan     = now()->month;
                $tahun     = now()->year;

                $nomorManual = "{$nomorManual}/{$kodeJenis}-{$sifat}/{$kodeBidang}/LDK SYAHID/{$bulan}/{$tahun}";
            }

            if (!preg_match(self::NOMOR_MANUAL_PATTERN, $nomorManual)) {
                return ['success' => false, 'error' => 'format'];
            }

            $parsed = $this->parseManual($nomorManual);

            $synced = NomorSuratCounter::syncManualNomor(
                $parsed['tahun'],
                $parsed['urut'],
                $parsed['sub'],
                now()
            );

            if (!$synced) {
                return ['success' => false, 'error' => 'mundur'];
            }

            $nomor = $nomorManual;
        } else {
            $nomor = $this->generateNomor($log, $kodeBidang);
        }

        $log->update([
            'status'        => 'approved',
            'nomor_surat'   => $nomor,
            'catatan_admin' => $catatanAdmin,
            'approved_by'   => $adminId,
            'approved_at'   => now(),
            'filename'      => $this->buildFilename($nomor),
        ]);

        return ['success' => true, 'error' => null];
    }

    public function generateNomor(SuratLog $log, string $kodeBidang): string
    {
        $now   = now();
        $tahun = $now->year;
        $bulan = $now->month;

        $nomor = NomorSuratCounter::nextNomor($tahun, $now);

        $urut     = $nomor['urut'];
        $subNomor = $nomor['sub'];

        $kodeJenis = $this->resolveKodeJenis($log);
        $sifat     = $this->resolveSifat($log);

        return "{$urut}{$subNomor}/{$kodeJenis}-{$sifat}/{$kodeBidang}/LDK SYAHID/{$bulan}/{$tahun}";
    }

    public function resolveKodeJenis(SuratLog $log): string
    {
        $map = LetterRegistry::getKodeJenis($log->jenis_surat);
        return $map['kode'] ?? 'Ph';
    }

    public function resolveSifat(SuratLog $log): string
    {
        $map = LetterRegistry::getKodeJenis($log->jenis_surat);

        if (!$map) {
            return 'e';
        }

        if ($map['sifat'] === null) {
            $jenis = $log->data['jenis_undangan'] ?? 'eksternal';
            return $jenis === 'internal' ? 'i' : 'e';
        }

        return $map['sifat'];
    }

    public function parseManual(string $nomor): array
    {
        $segments = explode('/', $nomor);
        $urutPart = $segments[0];
        $tahun    = (int) end($segments);

        if (str_contains($urutPart, '.')) {
            [$urut, $sub] = explode('.', $urutPart, 2);
        } else {
            $urut = $urutPart;
            $sub  = null;
        }

        return [
            'urut'  => (int) $urut,
            'sub'   => $sub !== null ? (int) $sub : null,
            'tahun' => $tahun,
        ];
    }

    public function buildFilename(string $nomor): string
    {
        $safe = str_replace(['/', ' '], ['_', '-'], $nomor);
        return $safe . '.pdf';
    }
}