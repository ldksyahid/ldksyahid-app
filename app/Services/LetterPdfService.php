<?php

namespace App\Services;

use App\Models\SuratLog;
use App\Support\LetterRegistry;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use ZipArchive;

class LetterPdfService
{
    public function streamOfficialPdf(SuratLog $suratLog)
    {
        $kodeVerifikasi = $suratLog->kode_verifikasi;
        $verifikasiUrl  = route('persuratan.verifikasi', $kodeVerifikasi);
        $qrCodeUri      = $this->generateQrCodeBase64($kodeVerifikasi);
        $nomorSurat     = $suratLog->nomor_surat ?: '-';
        $tanggalSurat   = ($suratLog->approved_at ?: now())->locale('id')->translatedFormat('d F Y');

        $pdf = Pdf::loadView('pdf.' . $suratLog->jenis_surat, [
            'suratLog'       => $suratLog,
            'label'          => $suratLog->label,
            'nomorSurat'     => $nomorSurat,
            'nomor'          => $nomorSurat,
            'tanggalSurat'   => $tanggalSurat,
            'kodeVerifikasi' => $kodeVerifikasi,
            'verifikasiUrl'  => $verifikasiUrl,
            'data'           => $suratLog->data ?? [],
            'qrCode'         => $qrCodeUri,
            'qrCodeUri'      => $qrCodeUri,
            'isDraft'        => false,
        ])->setPaper('a4', 'portrait');

        $filename = $suratLog->filename ?: 'surat-ldk-syahid.pdf';

        return $pdf->stream($filename);
    }

    public function streamDraftPdf(string $jenisSurat, array $data, ?SuratLog $existingLog = null)
    {
        $dummyLog = $existingLog ?: new SuratLog([
            'jenis_surat'     => $jenisSurat,
            'label'           => LetterRegistry::getLabel($jenisSurat),
            'nomor_surat'     => 'DRAFT/Ph-e/BPH/LDK SYAHID/' . now()->month . '/' . now()->year,
            'kode_verifikasi' => '00000000-draft-preview-00000000',
            'data'            => $data,
            'status'          => 'pending',
        ]);

        $kodeVerifikasi = $dummyLog->kode_verifikasi;
        $verifikasiUrl  = route('persuratan.verifikasi', $kodeVerifikasi);
        $qrCodeUri      = $this->generateQrCodeBase64($kodeVerifikasi);
        $nomorSurat     = ($dummyLog->nomor_surat && $dummyLog->nomor_surat !== '-') ? $dummyLog->nomor_surat : ('DRAFT/Ph-e/BPH/LDK SYAHID/' . now()->month . '/' . now()->year);
        $tanggalSurat   = ($dummyLog->created_at ?: now())->locale('id')->translatedFormat('d F Y');

        $pdf = Pdf::loadView('pdf.' . $jenisSurat, [
            'suratLog'       => $dummyLog,
            'label'          => $dummyLog->label ?: LetterRegistry::getLabel($jenisSurat),
            'nomorSurat'     => $nomorSurat,
            'nomor'          => $nomorSurat,
            'tanggalSurat'   => $tanggalSurat,
            'kodeVerifikasi' => $kodeVerifikasi,
            'verifikasiUrl'  => $verifikasiUrl,
            'data'           => $data,
            'qrCode'         => $qrCodeUri,
            'qrCodeUri'      => $qrCodeUri,
            'isDraft'        => true,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('draft-' . $jenisSurat . '.pdf');
    }

    public function streamExamplePdf(string $type)
    {
        $dummy          = $this->buildDummyData($type);
        $kodeVerifikasi = $dummy['suratLog']->kode_verifikasi;
        $verifikasiUrl  = route('persuratan.verifikasi', $kodeVerifikasi);
        $nomorSurat     = $dummy['suratLog']->nomor_surat;
        $tanggalSurat   = now()->locale('id')->translatedFormat('d F Y');

        $pdf = Pdf::loadView('pdf.' . $type, [
            'suratLog'       => $dummy['suratLog'],
            'label'          => $dummy['suratLog']->label,
            'nomorSurat'     => $nomorSurat,
            'nomor'          => $nomorSurat,
            'tanggalSurat'   => $tanggalSurat,
            'kodeVerifikasi' => $kodeVerifikasi,
            'verifikasiUrl'  => $verifikasiUrl,
            'data'           => $dummy['data'],
            'qrCode'         => $dummy['qrCodeUri'],
            'qrCodeUri'      => $dummy['qrCodeUri'],
            'isDraft'        => false,
        ])->setPaper('a4', 'portrait');

        return $pdf->download("contoh-surat-{$type}.pdf");
    }

    public function downloadAllExamplesZip()
    {
        $zipFileName = 'kumpulan-contoh-surat-ldk-syahid.zip';
        $zipPath     = storage_path('app/' . $zipFileName);

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Gagal membuat file ZIP.');
        }

        $types = LetterRegistry::all();

        foreach ($types as $type => $info) {
            $dummy          = $this->buildDummyData($type);
            $kodeVerifikasi = $dummy['suratLog']->kode_verifikasi;
            $verifikasiUrl  = route('persuratan.verifikasi', $kodeVerifikasi);
            $nomorSurat     = $dummy['suratLog']->nomor_surat;
            $tanggalSurat   = now()->locale('id')->translatedFormat('d F Y');

            $pdf = Pdf::loadView('pdf.' . $type, [
                'suratLog'       => $dummy['suratLog'],
                'label'          => $dummy['suratLog']->label,
                'nomorSurat'     => $nomorSurat,
                'nomor'          => $nomorSurat,
                'tanggalSurat'   => $tanggalSurat,
                'kodeVerifikasi' => $kodeVerifikasi,
                'verifikasiUrl'  => $verifikasiUrl,
                'data'           => $dummy['data'],
                'qrCode'         => $dummy['qrCodeUri'],
                'qrCodeUri'      => $dummy['qrCodeUri'],
                'isDraft'        => false,
            ])->setPaper('a4', 'portrait');

            $zip->addFromString("Contoh_{$info['label']}.pdf", $pdf->output());
        }

        $zip->close();

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }

    public function generateQrCodeBase64(string $kode): string
    {
        $verifyUrl = route('persuratan.verifikasi', $kode);
        $qrSvg     = QrCode::format('svg')->size(90)->margin(0)->generate($verifyUrl);

        return 'data:image/svg+xml;base64,' . base64_encode($qrSvg);
    }

    public function buildDummyData(string $type): array
    {
        $dummyLog = new SuratLog([
            'jenis_surat'     => $type,
            'label'           => LetterRegistry::getLabel($type),
            'nomor_surat'     => '001/Ph-e/BPH/LDK SYAHID/' . now()->month . '/' . now()->year,
            'kode_verifikasi' => 'contoh-verifikasi-' . $type,
            'status'          => 'approved',
            'created_at'      => now(),
            'approved_at'     => now(),
        ]);

        $data = [
            'kode_bidang'             => 'BPH',
            'nama_acara'              => 'Rihlah Akbar LDK Syahid 2026',
            'tema_acara'              => 'Menjalin Ukhuwah, Menggapai Mardhatillah',
            'nama_kegiatan'           => 'Studi Banding & Kolaborasi Dakwah',
            'nama_program'            => 'LDK Syahid Peduli Ummat',
            'hari_tanggal'            => now()->addDays(7)->format('Y-m-d') . ' to ' . now()->addDays(8)->format('Y-m-d'),
            'waktu'                   => '08.00 s.d. 16.00 WIB',
            'tempat'                  => 'Villa Bukit Cisarua, Bogor',
            'alamat_tempat'           => 'Jl. Raya Puncak KM 84, Cisarua, Bogor, Jawa Barat',
            'tempat_dipinjam'         => 'Aula Student Center Lt. 3 & Ruang Rapat Lt. 2',
            'ditujukan_kepada'        => 'Dekan Fakultas Sains dan Teknologi UIN Jakarta',
            'jabatan_tujuan'          => 'Dekan Fakultas Sains dan Teknologi',
            'nama_ketua_pelaksana'    => 'Muhammad Syauqi Mubarak',
            'nim_ketua_pelaksana'     => '11230600000067',
            'nama'                    => 'Ahmad Fulan',
            'nim'                     => '11230000000001',
            'ttl'                     => 'Jakarta, 17 Agustus 2003',
            'fakultas'                => 'Sains dan Teknologi',
            'jurusan'                 => 'Teknik Informatika',
            'jabatan'                 => 'Ketua Departemen Kaderisasi',
            'program_rekomendasi'     => 'Beasiswa Prestasi Nasional 2026',
            'pertimbangan'            => 'Mahasiswa aktif, berprestasi, dan memiliki integritas yang tinggi dalam berorganisasi.',
            'keperluan'               => 'Mendukung operasional dan perlengkapan kegiatan dakwah mahasiswa.',
            'penyelenggara'           => 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi',
            'materi'                  => 'Manajemen Organisasi Dakwah Kampus di Era Artificial Intelligence',
            'jenis_undangan'          => 'eksternal',
            'jenis_peminjaman'        => 'internal',
            'daftar_alat'             => "1. Proyektor Epson 3300 Lumens (1 unit)\n2. Kabel Roll 25 Meter (2 buah)\n3. Sound Portable Wireless (1 set)\n4. Mic Wireless (2 unit)",
            'perihal_imbauan'         => 'Partisipasi Seluruh Pengurus dalam Rangkaian Milad LDK Syahid ke-30',
            'poin_imbauan'            => "1. Menjaga ketertiban dan kebersihan sekretariat bersama.\n2. Menghadiri agenda opening ceremony tepat waktu.\n3. Memakai atribut resmi organisasi LDK Syahid.",
            'bentuk_kerjasama'        => 'Media Partner, Publikasi Konten Bersama, dan Booth Promosi',
        ];

        $dummyLog->data = $data;

        return [
            'suratLog'  => $dummyLog,
            'data'      => $data,
            'qrCodeUri' => $this->generateQrCodeBase64($dummyLog->kode_verifikasi),
        ];
    }
}