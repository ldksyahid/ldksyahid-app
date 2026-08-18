<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use ZipStream\CompressionMethod;
use ZipStream\ZipStream;
use App\Models\SuratLog;
use App\Models\MsSetting;

class LetterController extends Controller
{
    // =================================================================
    // 1. LANDING PAGE & USER ACTIONS
    // =================================================================
    public function index()
    {
        $waSekjen    = MsSetting::getSettingValue1('Persuratan', 'Kontak Sekjen') ?? '6285776923137';
        $namaSekjen  = MsSetting::getSettingValue2('Persuratan', 'Kontak Sekjen') ?? 'M. Zhaffar Rabbany';
        $waKestari   = MsSetting::getSettingValue1('Persuratan', 'Kontak Kestari') ?? '6285819353387';
        $namaKestari = MsSetting::getSettingValue2('Persuratan', 'Kontak Kestari') ?? 'M. Fiqhan Fajar';

        return view('landing-page.service.persuratan.index', [
            'title'       => 'Layanan Persuratan',
            'suratTypes'  => SuratLog::getSuratTypes(),
            'waSekjen'    => $waSekjen,
            'namaSekjen'  => $namaSekjen,
            'waKestari'   => $waKestari,
            'namaKestari' => $namaKestari,
            'riwayat'     => auth()->check()
                ? SuratLog::where('user_id', auth()->id())->latest()->take(5)->get()
                : collect(),
        ]);
    }

    public function submit(Request $request)
    {
        $validationRules = SuratLog::getValidationRules($request->jenis_surat);
        if (!$validationRules) {
            return back()->withErrors(['jenis_surat' => 'Jenis surat tidak valid.'])->withInput();
        }

        SuratLog::create([
            'user_id'     => auth()->id(),
            'jenis_surat' => $request->jenis_surat,
            'label'       => SuratLog::getSuratTypes()[$request->jenis_surat]['label'],
            'nomor_surat' => '-',
            'data'        => $request->validate($validationRules),
            'filename'    => '',
            'status'      => 'pending',
        ]);

        return back()->with('success', 'Pengajuan surat berhasil dikirim!');
    }

    public function riwayat()
    {
        $query = SuratLog::where('user_id', auth()->id());

        return view('landing-page.service.persuratan.riwayat', [
            'title'         => 'Riwayat Surat Saya',
            'riwayat'       => (clone $query)->latest()->paginate(10),
            'totalSurat'    => (clone $query)->count(),
            'pendingCount'  => (clone $query)->where('status', 'pending')->count(),
            'approvedCount' => (clone $query)->where('status', 'approved')->count(),
            'rejectedCount' => (clone $query)->where('status', 'rejected')->count(),
        ]);
    }

    public function download(SuratLog $suratLog)
    {
        abort_if(
            $suratLog->user_id !== auth()->id() || !$suratLog->isApproved(),
            403,
            'Akses tidak diizinkan.'
        );

        abort_if(
            empty($suratLog->filename) || $suratLog->nomor_surat === '-',
            404,
            'Dokumen belum tersedia.'
        );

        return $this->streamPdf($suratLog);
    }

    public function verifikasi(string $kode)
    {
        $suratLog = SuratLog::where('kode_verifikasi', $kode)->first();

        return view('landing-page.service.persuratan.verifikasi', [
            'title'    => 'Verifikasi Dokumen',
            'suratLog' => $suratLog,
            'kode'     => $kode,
        ]);
    }

    // =================================================================
    // 2. ADMIN PANEL ACTIONS
    // =================================================================
    public function indexAdmin(Request $request)
    {
        $suratLogs   = SuratLog::searchAdminPersuratan($request);
        $tableConfig = SuratLog::getTableConfig();

        return view('admin-page.service-request.persuratan.index', [
            'title'         => 'Letter Management',
            'suratLogs'     => $suratLogs,
            'tableConfig'   => $tableConfig,
            'suratTypes'    => SuratLog::getSuratTypes(),
            'totalCount'    => SuratLog::count(),
            'pendingCount'  => SuratLog::where('status', 'pending')->count(),
            'approvedCount' => SuratLog::where('status', 'approved')->count(),
            'rejectedCount' => SuratLog::where('status', 'rejected')->count(),
        ]);
    }

    public function showAdmin(SuratLog $suratLog)
    {
        $lastDocument = SuratLog::where('status', 'approved')
            ->whereNotNull('nomor_surat')
            ->where('nomor_surat', '!=', '-')
            ->latest('approved_at')
            ->first();

        return view('admin-page.service-request.persuratan.show', [
            'title'             => 'Letter Request Details',
            'suratLog'          => $suratLog->load('user', 'approvedBy'),
            'lastNomor'         => $lastDocument?->nomor_surat,
            'kodeBidangOptions' => SuratLog::getKodeBidangOptions(),
            'kodeBidangGroups'  => SuratLog::getKodeBidangGroups(),
        ]);
    }

    public function approve(Request $request, SuratLog $suratLog)
    {
        abort_if(!$suratLog->isPending(), 422, 'This document has already been processed.');

        $request->validate([
            'kode_bidang'        => 'required|string|max:20',
            'catatan_admin'      => 'nullable|string|max:500',
            'nomor_surat_manual' => 'nullable|string|max:100',
        ]);

        $result = $suratLog->executeApproval(
            $request->nomor_surat_manual,
            $request->catatan_admin,
            auth()->id(),
            $request->kode_bidang
        );

        if (!$result['success']) {
            $message = match ($result['error']) {
                'mundur' => 'Manual letter number is invalid: this sequence goes backward or conflicts with previously issued numbers.',
                default  => 'Manual letter number format is invalid.',
            };

            return back()->withErrors(['nomor_surat_manual' => $message])->withInput();
        }

        return redirect()
            ->route('admin.persuratan.show', $suratLog)
            ->with('success', 'Letter request has been approved and the letter number has been issued successfully.');
    }

    public function reject(Request $request, SuratLog $suratLog)
    {
        abort_if(!$suratLog->isPending(), 422, 'This document has already been processed.');

        $request->validate(['catatan_admin' => 'required|string|max:500']);

        $suratLog->update([
            'status'        => 'rejected',
            'catatan_admin' => $request->catatan_admin,
            'approved_by'   => auth()->id(),
            'approved_at'   => now(),
        ]);

        return back()->with('success', 'Letter request has been rejected.');
    }

    public function downloadAdmin(SuratLog $suratLog)
    {
        abort_if(!$suratLog->isApproved(), 403, 'Surat belum disetujui.');

        abort_if(
            empty($suratLog->filename) || $suratLog->nomor_surat === '-',
            404,
            'Dokumen belum tersedia.'
        );

        return $this->streamPdf($suratLog);
    }

    /** Download every letter layout with safe example data for visual review. */
    public function downloadExampleTemplates()
    {
        $types           = SuratLog::getSuratTypes();
        $sampleData      = $this->exampleLetterData();
        $verificationUrl = route('service.persuratan.index');
        $qrCode          = 'data:image/svg+xml;base64,' . base64_encode(
            (string) QrCode::size(120)->margin(0)->generate($verificationUrl)
        );

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

    public function destroy(SuratLog $suratLog)
    {
        if (method_exists($suratLog, 'deleteModel')) {
            $suratLog->deleteModel();
        } else {
            $suratLog->delete();
        }

        return redirect()
            ->route('admin.persuratan.index')
            ->with('success', 'Data pengajuan berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (method_exists(SuratLog::class, 'bulkDeleteModel')) {
            SuratLog::bulkDeleteModel($ids);
        } else {
            SuratLog::whereIn('id', $ids)->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Surat terpilih berhasil dihapus!'
        ]);
    }

    // =================================================================
    // 3. PRIVATE METHODS (PDF & QR CODE)
    // =================================================================
    private function streamPdf(SuratLog $suratLog): mixed
    {
        $approvalDate = $suratLog->approved_at
            ? $suratLog->approved_at->locale('id')->translatedFormat('d F Y')
            : now()->locale('id')->translatedFormat('d F Y');

        $verificationUrl = route('persuratan.verifikasi', ['kode' => $suratLog->kode_verifikasi]);

        $qrSvg        = QrCode::size(120)->margin(0)->generate($verificationUrl);
        $qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode((string) $qrSvg);

        $pdfView = $this->getPdfView($suratLog->jenis_surat);

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

    private function getPdfView(?string $type): string
    {
        if ($type && View::exists('pdf.' . $type)) {
            return 'pdf.' . $type;
        }

        return 'pdf.surat';
    }

    private function exampleLetterNumber(string $type): string
    {
        $codes = [
            'izin-orang-tua'              => 'Ph-e',
            'peminjaman-alat'             => 'Ph-e',
            'peminjaman-tempat-kampus'    => 'Ph-i',
            'peminjaman-tempat-fakultas'  => 'Ph-i',
            'peminjaman-tempat-luar-kampus' => 'Ph-e',
            'permohonan-bantuan-dana'     => 'Ph-e',
            'permohonan-izin-luar-kampus' => 'Ph-e',
            'surat-rekomendasi'           => 'SR-e',
            'surat-undangan'              => 'Und-e',
            'surat-aktif-organisasi'      => 'S.Ket-e',
            'permohonan-pemateri'         => 'Ph-e',
            'kerja-sama-sponsorship'      => 'Ks-e',
            'surat-pemberitahuan'         => 'Pb-e',
        ];

        return sprintf('900/%s/KDR/LDK SYAHID/%d/%d', $codes[$type] ?? 'Ph-e', now()->month, now()->year);
    }

    private function exampleLetterData(): array
    {
        return [
            'kode_bidang' => 'KDR', 'nama_acara' => 'Kegiatan Contoh LDK Syahid',
            'tema_acara' => 'Membangun Generasi Berdaya', 'hari_tanggal' => now()->toDateString(),
            'waktu' => '08.00–12.00 WIB', 'tempat' => 'Aula Student Center UIN Jakarta',
            'jenis_peminjaman' => 'eksternal', 'ditujukan_kepada' => 'Pihak Terkait',
            'daftar_alat' => "1. Proyektor\n2. Sound system", 'nama_ketua_pelaksana' => 'Ahmad Fulan',
            'nim_ketua_pelaksana' => '11230000000001', 'tempat_dipinjam' => 'Aula Student Center UIN Jakarta',
            'nama_program' => 'Program Kaderisasi', 'keperluan' => 'keperluan administrasi kegiatan',
            'alamat_tempat' => 'Jl. Ir. H. Juanda No. 95, Tangerang Selatan', 'nama' => 'Muhammad Fakhri Alfarisi',
            'nim' => '11230910000029', 'fakultas' => 'Sains dan Teknologi', 'jurusan' => 'Teknik Informatika',
            'jabatan' => 'Anggota Bidang Kaderisasi', 'program_rekomendasi' => 'Program Beasiswa Prestasi',
            'pertimbangan' => 'aktif berkontribusi dalam kegiatan organisasi', 'jenis_undangan' => 'eksternal',
            'ttl' => 'Tangerang, 26 Januari 2005', 'penyelenggara' => 'BAZNAS',
            'materi' => 'Kepemimpinan dan Pengembangan Diri', 'bentuk_kerjasama' => 'Dukungan publikasi dan pendanaan',
            'nama_kegiatan' => 'Kegiatan Contoh LDK Syahid',
        ];
    }
}