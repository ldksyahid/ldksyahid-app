<?php

namespace App\Http\Controllers;

use App\Models\SuratLog;
use App\Services\LetterNumberingService;
use App\Services\LetterPdfService;
use App\Support\DepartmentRegistry;
use App\Support\LetterRegistry;
use Illuminate\Http\Request;

class LetterAdminController extends Controller
{
    protected LetterPdfService $pdfService;
    protected LetterNumberingService $numberingService;

    public function __construct(LetterPdfService $pdfService, LetterNumberingService $numberingService)
    {
        $this->pdfService       = $pdfService;
        $this->numberingService = $numberingService;
    }

    public function index(Request $request)
    {
        $suratLogs   = SuratLog::searchAdminPersuratan($request);
        $tableConfig = SuratLog::getTableConfig();

        return view('admin-page.service-request.persuratan.index', [
            'title'         => 'Letter Management',
            'suratLogs'     => $suratLogs,
            'tableConfig'   => $tableConfig,
            'suratTypes'    => LetterRegistry::all(),
            'totalCount'    => SuratLog::count(),
            'pendingCount'  => SuratLog::pending()->count(),
            'approvedCount' => SuratLog::approved()->count(),
            'rejectedCount' => SuratLog::rejected()->count(),
            'expiredCount'  => SuratLog::expired()->count(),
        ]);
    }

    public function show(SuratLog $suratLog)
    {
        $suratLog->load(['user', 'approvedBy']);

        $lastDocument = SuratLog::approved()
            ->latest('approved_at')
            ->first();

        $lastNomor = $lastDocument ? $lastDocument->nomor_surat : 'Belum ada surat yang disetujui';

        return view('admin-page.service-request.persuratan.show', [
            'title'             => 'Review Pengajuan Surat — ' . $suratLog->label,
            'suratLog'          => $suratLog,
            'lastNomor'         => $lastNomor,
            'kodeBidangOptions' => DepartmentRegistry::options(),
            'kodeBidangGroups'  => DepartmentRegistry::groups(),
        ]);
    }

    public function approve(Request $request, SuratLog $suratLog)
    {
        if ($suratLog->isApproved()) {
            return redirect()
                ->route('admin.persuratan.show', $suratLog)
                ->with('error', 'Surat ini sudah disetujui sebelumnya.');
        }

        $request->validate([
            'mode_penomoran' => 'required|in:otomatis,manual',
            'nomor_manual'   => 'nullable|string|max:100',
            'catatan_admin'  => 'nullable|string|max:500',
            'kode_bidang'    => 'required|string|max:30',
        ]);

        $mode        = $request->mode_penomoran;
        $nomorManual = $mode === 'manual' ? trim($request->nomor_manual) : null;
        $kodeBidang  = $request->kode_bidang;

        if ($mode === 'manual' && empty($nomorManual)) {
            return redirect()
                ->route('admin.persuratan.show', $suratLog)
                ->withInput()
                ->with('error', 'Nomor surat manual wajib diisi jika memilih mode manual.');
        }

        $result = $this->numberingService->approve(
            $suratLog,
            $nomorManual,
            $request->catatan_admin,
            auth()->id(),
            $kodeBidang
        );

        if (!$result['success']) {
            if ($result['error'] === 'format') {
                return redirect()
                    ->route('admin.persuratan.show', $suratLog)
                    ->withInput()
                    ->with('error', 'Format nomor surat manual tidak valid. Contoh format lengkap: 001/Ph-e/BPH/LDK-SYAHID/8/2026 atau cukup ketik nomor urutnya saja, misal: 001 atau 001.01');
            }

            if ($result['error'] === 'mundur') {
                return redirect()
                    ->route('admin.persuratan.show', $suratLog)
                    ->withInput()
                    ->with('error', 'Nomor surat yang dimasukkan lebih kecil dari counter saat ini (counter tidak boleh mundur).');
            }
        }

        return redirect()
            ->route('admin.persuratan.show', $suratLog)
            ->with('success', "Surat berhasil disetujui dengan Nomor: {$suratLog->nomor_surat}");
    }

    public function reject(Request $request, SuratLog $suratLog)
    {
        if ($suratLog->isApproved()) {
            return redirect()
                ->route('admin.persuratan.show', $suratLog)
                ->with('error', 'Surat yang sudah disetujui tidak dapat ditolak.');
        }

        $request->validate([
            'catatan_admin' => 'required|string|max:500',
        ], [
            'catatan_admin.required' => 'Alasan penolakan wajib diisi agar pengaju mengetahui kekurangannya.',
        ]);

        $suratLog->update([
            'status'        => 'rejected',
            'catatan_admin' => $request->catatan_admin,
            'approved_by'   => auth()->id(),
            'approved_at'   => now(),
        ]);

        return redirect()
            ->route('admin.persuratan.show', $suratLog)
            ->with('success', 'Pengajuan surat telah ditolak.');
    }

    public function download(SuratLog $suratLog)
    {
        return $this->pdfService->streamOfficialPdf($suratLog);
    }

    public function downloadExample(string $type)
    {
        return $this->pdfService->streamExamplePdf($type);
    }

    public function downloadAllExamples()
    {
        return $this->pdfService->downloadAllExamplesZip();
    }

    public function downloadExampleTemplates()
    {
        return $this->downloadAllExamples();
    }

    public function destroy(SuratLog $suratLog)
    {
        $suratLog->delete();

        return redirect()
            ->route('admin.persuratan.index')
            ->with('success', 'Data pengajuan surat berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        $ids = array_filter(array_map('intval', $ids));

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada data yang dipilih.'], 422);
        }

        SuratLog::whereIn('id', $ids)->delete();

        return response()->json(['success' => true, 'message' => count($ids) . ' pengajuan surat berhasil dihapus.']);
    }
}