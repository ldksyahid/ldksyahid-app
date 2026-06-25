<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\SuratLog;
use App\Models\MsSetting; // <-- WAJIB IMPORT INI UNTUK SETTING KESTARI

class LetterController extends Controller
{
    // =================================================================
    // 1. LANDING PAGE & USER ACTIONS
    // =================================================================
    public function index()
    {
        // Fitur Setting Kestari yang tadi kita buat!
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
    // 2. ADMIN PANEL ACTIONS (SKINNY CONTROLLER!)
    // =================================================================
    public function indexAdmin(Request $request)
    {
        // Sangat Rapi! Logic pencarian diserahkan ke Model SuratLog
        $suratLogs   = SuratLog::searchAdminPersuratan($request);
        $tableConfig = SuratLog::getTableConfig(); // Panggil konfigurasi UI dari model

        return view('admin-page.service-request.persuratan.index', [
            'title'       => 'Manajemen Persuratan',
            'suratLogs'   => $suratLogs,
            'tableConfig' => $tableConfig,
            'suratTypes'  => SuratLog::getSuratTypes(),
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
            'title'             => 'Detail Pengajuan Surat',
            'suratLog'          => $suratLog->load('user', 'approvedBy'),
            'lastNomor'         => $lastDocument?->nomor_surat,
            'kodeBidangOptions' => SuratLog::getKodeBidangOptions(),
            'kodeBidangGroups'  => SuratLog::getKodeBidangGroups(),
        ]);
    }

    public function approve(Request $request, SuratLog $suratLog)
    {
        abort_if(!$suratLog->isPending(), 422, 'Dokumen ini sudah diproses sebelumnya.');

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
                'mundur' => 'Nomor surat manual tidak valid: nomor ini mundur atau bentrok dengan nomor yang sudah diterbitkan sebelumnya.',
                default  => 'Format nomor surat manual tidak valid.',
            };

            return back()->withErrors(['nomor_surat_manual' => $message])->withInput();
        }

        return redirect()
            ->route('admin.persuratan.show', $suratLog)
            ->with('success', 'Surat berhasil disetujui dan nomor surat telah diterbitkan.');
    }

    public function reject(Request $request, SuratLog $suratLog)
    {
        abort_if(!$suratLog->isPending(), 422, 'Dokumen ini sudah diproses sebelumnya.');

        $request->validate(['catatan_admin' => 'required|string|max:500']);

        $suratLog->update([
            'status'        => 'rejected',
            'catatan_admin' => $request->catatan_admin,
            'approved_by'   => auth()->id(),
            'approved_at'   => now(),
        ]);

        return back()->with('success', 'Pengajuan surat telah ditolak.');
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

    public function destroy(SuratLog $suratLog)
    {
        // Pakai deleteModel() agar PDF-nya juga ikut terhapus dari server
        if(method_exists($suratLog, 'deleteModel')) {
            $suratLog->deleteModel(); 
        } else {
            $suratLog->delete();
        }

        return redirect()
            ->route('admin.persuratan.index')
            ->with('success', 'Data pengajuan berhasil dihapus.');
    }

    // (Opsional) Tambahkan bulkDestroy jika Aa mau fitur hapus massal
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if(method_exists(SuratLog::class, 'bulkDeleteModel')) {
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

$pdfView = View::exists('landing-page.service.e-letter.' . $suratLog->jenis_surat)
            ? 'landing-page.service.e-letter.' . $suratLog->jenis_surat
            : 'landing-page.service.e-letter.surat';

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
}