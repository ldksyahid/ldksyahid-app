<?php

namespace App\Http\Controllers;

use App\Constants\SettingKey\Key1;
use App\Constants\SettingKey\Key2;
use App\Models\MsSetting;
use App\Models\SuratLog;
use App\Services\LetterPdfService;
use App\Services\WhatsApp;
use App\Support\LetterRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LetterController extends Controller
{
    protected LetterPdfService $pdfService;

    public function __construct(LetterPdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function index(Request $request)
    {
        $waKestari   = MsSetting::getSettingValue1(Key1::PERSURATAN, Key2::KontakKestari) ?: '6285819353387';
        $namaKestari = MsSetting::getSettingValue2(Key1::PERSURATAN, Key2::KontakKestari) ?: 'Biro Kesekretariatan';
        $waSekjen    = MsSetting::getSettingValue1(Key1::PERSURATAN, Key2::KontakSekjen) ?: '6285776923137';
        $namaSekjen  = MsSetting::getSettingValue2(Key1::PERSURATAN, Key2::KontakSekjen) ?: 'Sekretaris Jenderal';

        $reapplyLog = null;
        if ($request->filled('reapply') && auth()->check()) {
            $reapplyLog = SuratLog::where('id', $request->reapply)
                ->where('user_id', auth()->id())
                ->first();
        }

        return view('landing-page.service.persuratan.index', [
            'title'       => 'Layanan Persuratan — LDK Syahid',
            'suratTypes'  => LetterRegistry::all(),
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

    public function submit(Request $request)
    {
        $request->validate(['jenis_surat' => 'required|string']);

        $validationRules = LetterRegistry::getValidationRules($request->jenis_surat);
        if (!$validationRules) {
            return back()->withInput()->withErrors(['jenis_surat' => 'Jenis surat tidak valid.']);
        }

        $validated = $request->validate($validationRules);
        unset($validated['jenis_surat']);

        $suratLog = SuratLog::create([
            'user_id'     => auth()->id(),
            'jenis_surat' => $request->jenis_surat,
            'label'       => LetterRegistry::getLabel($request->jenis_surat),
            'nomor_surat' => '-',
            'data'        => $validated,
            'status'      => 'pending',
        ]);

        // Smart Routing: Pusat -> Kestari, Fakultas -> Sekjen
        $isFakultas  = $suratLog->isFakultas();
        $targetPhone = $isFakultas
            ? (MsSetting::getSettingValue1(Key1::PERSURATAN, Key2::KontakSekjen) ?: '6285776923137')
            : (MsSetting::getSettingValue1(Key1::PERSURATAN, Key2::KontakKestari) ?: '6285819353387');

        $normPhone = preg_replace('/[^0-9]/', '', $targetPhone);
        if ($normPhone) {
            Cache::put("whatsapp_pending_letter:{$normPhone}", $suratLog->id, now()->addDays(7));
        }

        $applicantName = $suratLog->user?->name ?: ($validated['nama'] ?? 'Pemohon');

        WhatsApp::sendLetterRequestNotification([
            'letterId'    => $suratLog->id,
            'name'        => $applicantName,
            'letterType'  => $suratLog->label,
            'department'  => $suratLog->labelBidangPengaju(),
            'activity'    => $suratLog->keperluanKegiatan(),
            'previewUrl'  => route('service.persuratan.preview', $suratLog->kode_verifikasi),
            'targetPhone' => $targetPhone,
        ]);

        return redirect()
            ->route('service.persuratan.index')
            ->with('success', "Pengajuan '{$suratLog->label}' berhasil dikirim! Silakan pantau status surat di menu Riwayat.");
    }

    public function riwayat()
    {
        $query = SuratLog::where('user_id', auth()->id());

        $totalSurat    = (clone $query)->count();
        $pendingCount  = (clone $query)->pending()->count();
        $approvedCount = (clone $query)->approved()->count();
        $rejectedCount = (clone $query)->rejected()->count();
        $expiredCount  = (clone $query)->expired()->count();

        $riwayat = $query->latest()->paginate(10);

        return view('landing-page.service.persuratan.riwayat', [
            'title'         => 'Riwayat Pengajuan Surat — LDK Syahid',
            'riwayat'       => $riwayat,
            'totalSurat'    => $totalSurat,
            'pendingCount'  => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'expiredCount'  => $expiredCount,
        ]);
    }

    public function download(SuratLog $suratLog)
    {
        if (!auth()->check() || auth()->id() !== $suratLog->user_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh dokumen ini.');
        }

        if (!$suratLog->isApproved()) {
            return redirect()
                ->route('service.persuratan.riwayat')
                ->with('error', 'Surat belum disetujui atau tidak dapat diunduh.');
        }

        return $this->pdfService->streamOfficialPdf($suratLog);
    }

    public function previewDraft(Request $request)
    {
        $request->validate(['jenis_surat' => 'required|string']);

        $rules = LetterRegistry::getValidationRules($request->jenis_surat);
        if (!$rules) {
            abort(404, 'Jenis surat tidak valid.');
        }

        $validated = $request->validate($rules);
        unset($validated['jenis_surat']);

        return $this->pdfService->streamDraftPdf($request->jenis_surat, $validated);
    }

    public function verifikasi(Request $request, ?string $kode = null)
    {
        $kode = $kode ?: $request->query('kode', '');
        $suratLog = null;

        if (!empty($kode)) {
            $suratLog = SuratLog::where('kode_verifikasi', $kode)->first();
        }

        return view('landing-page.service.persuratan.verifikasi', [
            'title'    => 'Verifikasi Keaslian Dokumen — LDK Syahid',
            'suratLog' => $suratLog,
            'kode'     => $kode,
        ]);
    }

    public function verifikasiPublik(Request $request, ?string $kode = null)
    {
        return $this->verifikasi($request, $kode);
    }
}