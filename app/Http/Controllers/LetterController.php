<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratLog;
use App\Models\MsSetting;
use App\Services\WhatsApp;
use App\Services\LetterPdfService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LetterController extends Controller
{
    public function __construct(
        protected LetterPdfService $pdfService
    ) {}

    /**
     * Landing page for letter submission service.
     */
    public function index(Request $request)
    {
        $waSekjen    = MsSetting::getSettingValue1('Persuratan', 'Kontak Sekjen') ?? '6285776923137';
        $namaSekjen  = MsSetting::getSettingValue2('Persuratan', 'Kontak Sekjen') ?? 'M. Zhafar Rabbany';
        $waKestari   = MsSetting::getSettingValue1('Persuratan', 'Kontak Kestari') ?? '6285819353387';
        $namaKestari = MsSetting::getSettingValue2('Persuratan', 'Kontak Kestari') ?? 'M. Fiqhan Fajar';

        $reapplyLog = null;
        if ($request->filled('reapply') && auth()->check()) {
            $reapplyLog = SuratLog::where('id', $request->reapply)
                ->where('user_id', auth()->id())
                ->first();
        }

        return view('landing-page.service.persuratan.index', [
            'title'       => 'Layanan Persuratan',
            'suratTypes'  => SuratLog::getSuratTypes(),
            'waSekjen'    => $waSekjen,
            'namaSekjen'  => $namaSekjen,
            'waKestari'   => $waKestari,
            'namaKestari' => $namaKestari,
            'reapplyLog'  => $reapplyLog,
            'riwayat'     => auth()->check()
                ? SuratLog::where('user_id', auth()->id())->latest()->take(5)->get()
                : collect(),
        ]);
    }

    /**
     * Submit a new letter request.
     */
    public function submit(Request $request)
    {
        $validationRules = SuratLog::getValidationRules($request->jenis_surat);
        if (!$validationRules) {
            return back()->withErrors(['jenis_surat' => 'Jenis surat tidak valid.'])->withInput();
        }

        $suratLog = SuratLog::create([
            'user_id'     => auth()->id(),
            'jenis_surat' => $request->jenis_surat,
            'label'       => SuratLog::getSuratTypes()[$request->jenis_surat]['label'],
            'nomor_surat' => '-',
            'data'        => $request->validate($validationRules),
            'filename'    => '',
            'status'      => 'pending',
        ]);

        // Send WhatsApp notification based on applicant origin:
        // - Pengurus Pusat -> Kontak Kestari
        // - LDK Syahid Fakultas (LDKSF) -> Kontak Sekjen
        $isFakultas  = $suratLog->isFakultas();
        $targetPhone = $isFakultas
            ? (MsSetting::getSettingValue1('Persuratan', 'Kontak Sekjen') ?: '6285776923137')
            : (MsSetting::getSettingValue1('Persuratan', 'Kontak Kestari') ?: '6285819353387');

        $activity = $suratLog->data['nama_acara']
            ?? $suratLog->data['nama_program']
            ?? $suratLog->data['nama_kegiatan']
            ?? $suratLog->data['keperluan']
            ?? $suratLog->data['materi']
            ?? $suratLog->data['program_rekomendasi']
            ?? '-';

        $previewUrl = route('service.persuratan.preview', ['kode' => $suratLog->kode_verifikasi]);

        $notificationData = [
            'letterId'    => $suratLog->id,
            'name'        => auth()->user()?->name ?: ($suratLog->data['nama'] ?? 'Pemohon'),
            'letterType'  => $suratLog->label,
            'department'  => $suratLog->labelBidangPengaju(),
            'activity'    => $activity,
            'previewUrl'  => $previewUrl,
            'targetPhone' => $targetPhone,
        ];

        try {
            WhatsApp::sendLetterRequestNotification($notificationData);

            $normPhone = preg_replace('/[^0-9]/', '', $targetPhone);
            if (!empty($normPhone)) {
                Cache::put("whatsapp_pending_letter:{$normPhone}", $suratLog->id, now()->addDays(7));
            }
        } catch (\Throwable $e) {
            Log::error('[LetterController] WhatsApp notification dispatch failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Pengajuan surat berhasil dikirim!');
    }

    /**
     * User's personal letter request history page.
     */
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
            'expiredCount'  => (clone $query)->where('status', 'expired')->count(),
        ]);
    }

    /**
     * User download approved official letter PDF.
     */
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

        return $this->pdfService->downloadApproved($suratLog);
    }

    /**
     * Stream a draft preview of the document.
     */
    public function previewDraft(string $kode)
    {
        $suratLog = SuratLog::where('kode_verifikasi', $kode)->firstOrFail();

        return $this->pdfService->streamDraft($suratLog);
    }

    /**
     * Public verification page for checking letter authenticity via QR / URL.
     */
    public function verifikasi(string $kode)
    {
        $suratLog = SuratLog::where('kode_verifikasi', $kode)->first();

        return view('landing-page.service.persuratan.verifikasi', [
            'title'    => 'Verifikasi Dokumen',
            'suratLog' => $suratLog,
            'kode'     => $kode,
        ]);
    }
}