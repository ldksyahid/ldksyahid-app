<?php

namespace App\Services;

use App\Models\SuratLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use ZipStream\CompressionMethod;
use ZipStream\ZipStream;

class LetterPdfService
{
    /**
     * Resolve the corresponding Blade view for a letter type.
     */
    public function getPdfView(?string $type): string
    {
        if ($type && View::exists('pdf.' . $type)) {
            return 'pdf.' . $type;
        }

        return 'pdf.surat';
    }

    /**
     * Generate base64 data URI for a QR code SVG.
     */
    public function generateQrCodeBase64(string $url, int $size = 120): string
    {
        $qrSvg = QrCode::size($size)->margin(0)->generate($url);
        return 'data:image/svg+xml;base64,' . base64_encode((string) $qrSvg);
    }

    /**
     * Stream a draft PDF (used for previewing letter before/after approval).
     */
    public function streamDraft(SuratLog $suratLog)
    {
        $approvalDate    = now()->locale('id')->translatedFormat('d F Y');
        $verificationUrl = route('persuratan.verifikasi', ['kode' => $suratLog->kode_verifikasi]);
        $qrCodeBase64    = $this->generateQrCodeBase64($verificationUrl);
        $pdfView         = $this->getPdfView($suratLog->jenis_surat);

        $draftNomor = $suratLog->isApproved()
            ? $suratLog->nomor_surat
            : ('[DRAFT] ' . ($suratLog->kodeBidangPengaju() ?: 'KST') . '/LDK SYAHID/' . now()->month . '/' . now()->year);

        return Pdf::loadView($pdfView, [
            'data'           => $suratLog->data,
            'nomorSurat'     => $draftNomor,
            'tanggalSurat'   => $approvalDate,
            'label'          => $suratLog->label,
            'user'           => $suratLog->user,
            'kodeVerifikasi' => $suratLog->kode_verifikasi,
            'verifikasiUrl'  => $verificationUrl,
            'qrCode'         => $qrCodeBase64,
            'suratLog'       => $suratLog,
            'isDraft'        => !$suratLog->isApproved(),
        ])->setPaper('a4', 'portrait')->stream('DRAFT-' . ($suratLog->filename ?: $suratLog->jenis_surat . '.pdf'));
    }

    /**
     * Download the official approved PDF document.
     */
    public function downloadApproved(SuratLog $suratLog)
    {
        $approvalDate = $suratLog->approved_at
            ? $suratLog->approved_at->locale('id')->translatedFormat('d F Y')
            : now()->locale('id')->translatedFormat('d F Y');

        $verificationUrl = route('persuratan.verifikasi', ['kode' => $suratLog->kode_verifikasi]);
        $qrCodeBase64    = $this->generateQrCodeBase64($verificationUrl);
        $pdfView         = $this->getPdfView($suratLog->jenis_surat);

        return Pdf::loadView($pdfView, [
            'data'           => $suratLog->data,
            'nomorSurat'     => $suratLog->nomor_surat,
            'tanggalSurat'   => $approvalDate,
            'label'          => $suratLog->label,
            'user'           => $suratLog->user,
            'kodeVerifikasi' => $suratLog->kode_verifikasi,
            'verifikasiUrl'  => $verificationUrl,
            'qrCode'         => $qrCodeBase64,
            'suratLog'       => $suratLog,
        ])->setPaper('a4', 'portrait')->download($suratLog->filename ?: $suratLog->jenis_surat . '.pdf');
    }

    /**
     * Generate and stream a ZIP package containing sample PDFs of all template layouts.
     */
    public function downloadExampleTemplates()
    {
        $types           = SuratLog::getSuratTypes();
        $sampleData      = $this->exampleLetterData();
        $verificationUrl = route('service.persuratan.index');
        $qrCode          = $this->generateQrCodeBase64($verificationUrl);

        return response()->streamDownload(function () use ($types, $sampleData, $verificationUrl, $qrCode) {
            $zip = new ZipStream(
                sendHttpHeaders: false,
                defaultCompressionMethod: CompressionMethod::STORE,
            );

            foreach ($types as $type => $definition) {
                $data  = array_intersect_key($sampleData, array_flip($definition['fields']));
                $view  = $this->getPdfView($type);
                $nomor = $this->exampleLetterNumber($type);

                $pdf = Pdf::loadView($view, [
                    'data'           => $data,
                    'nomorSurat'     => $nomor,
                    'tanggalSurat'   => now()->locale('id')->translatedFormat('d F Y'),
                    'label'          => $definition['label'],
                    'user'           => null,
                    'kodeVerifikasi' => 'CONTOH-TEMPLATE',
                    'verifikasiUrl'  => $verificationUrl,
                    'qrCode'         => $qrCode,
                    'suratLog'       => null,
                ])->setPaper('a4', 'portrait')->output();

                $zip->addFile(
                    fileName: sprintf('%s-%s.pdf', $type, str_replace('/', '-', $nomor)),
                    data: $pdf,
                );
            }

            $zip->finish();
        }, 'contoh-template-persuratan.zip', [
            'Content-Type' => 'application/zip',
        ]);
    }

    /**
     * Example letter number for sample templates.
     */
    public function exampleLetterNumber(string $type): string
    {
        $codes = [
            'izin-orang-tua'                      => 'Ph-e',
            'peminjaman-alat'                     => 'Ph-e',
            'peminjaman-tempat-kampus'            => 'Ph-i',
            'peminjaman-tempat-fakultas'          => 'Ph-i',
            'peminjaman-tempat-luar-kampus'       => 'Ph-e',
            'permohonan-bantuan-dana'             => 'Ph-e',
            'permohonan-izin-luar-kampus'         => 'Ph-e',
            'surat-rekomendasi'                   => 'SR-e',
            'surat-undangan'                      => 'Und-e',
            'surat-aktif-organisasi'              => 'S.Ket-e',
            'permohonan-pemateri'                 => 'Ph-e',
            'permohonan-sambutan'                 => 'Ph-e',
            'surat-izin-buka-stand'               => 'Ph-i',
            'surat-izin-pengambilan-gambar-video' => 'Ph-i',
            'surat-kunjungan-lembaga'             => 'Ph-e',
            'surat-imbauan'                       => 'Pb-e',
            'kerja-sama-sponsorship'              => 'Ks-e',
            'surat-pemberitahuan'                 => 'Pb-e',
        ];

        return sprintf('900/%s/KDR/LDK SYAHID/%d/%d', $codes[$type] ?? 'Ph-e', now()->month, now()->year);
    }

    /**
     * Sample mock data for generating all template examples.
     */
    public function exampleLetterData(): array
    {
        return [
            'kode_bidang'          => 'KDR',
            'nama_acara'           => 'Kegiatan Contoh LDK Syahid',
            'tema_acara'           => 'Membangun Generasi Berdaya',
            'hari_tanggal'         => now()->toDateString(),
            'waktu'                => '08.00 s.d. 16.00 WIB',
            'tempat'               => 'Aula Student Center UIN Jakarta',
            'jenis_peminjaman'     => 'eksternal',
            'ditujukan_kepada'     => 'Pihak Terkait',
            'jabatan_tujuan'       => 'Pimpinan Lembaga',
            'daftar_alat'          => "1. Proyektor\n2. Sound system",
            'nama_ketua_pelaksana' => 'Ahmad Fulan',
            'nim_ketua_pelaksana'  => '11230000000001',
            'tempat_dipinjam'      => 'Aula Student Center UIN Jakarta',
            'nama_program'         => 'Program Kaderisasi',
            'keperluan'            => 'Penyelenggaraan agenda kaderisasi dan kegiatan resmi organisasi.',
            'alamat_tempat'        => 'Jl. Ir. H. Juanda No. 95, Tangerang Selatan',
            'nama'                 => 'Muhammad Fakhri Alfarisi',
            'nim'                  => '11230910000029',
            'fakultas'             => 'Sains dan Teknologi',
            'jurusan'              => 'Teknik Informatika',
            'jabatan'              => 'Anggota Bidang Kaderisasi',
            'program_rekomendasi'  => 'Program Beasiswa Prestasi',
            'pertimbangan'         => 'Aktif berkontribusi dalam kegiatan organisasi.',
            'jenis_undangan'       => 'eksternal',
            'ttl'                  => 'Tangerang, 26 Januari 2005',
            'penyelenggara'        => 'BAZNAS RI',
            'materi'               => 'Kepemimpinan dan Pengembangan Diri',
            'bentuk_kerjasama'     => 'Dukungan publikasi dan pendanaan',
            'nama_kegiatan'        => 'Kegiatan Contoh LDK Syahid',
            'perihal_imbauan'      => 'Kesiapsiagaan dan Menjaga Fasilitas',
            'poin_imbauan'         => "1. Menjaga kebersihan dan ketertiban sekretariat.\n2. Mematikan alat elektronik setelah selesai digunakan.",
        ];
    }
}