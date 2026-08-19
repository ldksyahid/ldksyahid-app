<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratLog;
use App\Services\WhatsApp;
use App\Services\LetterPdfService;
use Illuminate\Support\Facades\Log;

class LetterAdminController extends Controller
{
    public function __construct(
        protected LetterPdfService $pdfService
    ) {}

    /**
     * Display a listing of all letter requests for admin.
     */
    public function index(Request $request)
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
            'expiredCount'  => SuratLog::where('status', 'expired')->count(),
        ]);
    }

    /**
     * Display the specified letter request details for review.
     */
    public function show(SuratLog $suratLog)
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

    /**
     * Approve the letter request and issue an official letter number.
     */
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

        // Notify applicant via WhatsApp if phone number is available
        if (!empty($suratLog->data['whatsapp'])) {
            try {
                WhatsApp::sendLetterApproved([
                    'name'         => $suratLog->user?->name ?: ($suratLog->data['nama'] ?? 'Pemohon'),
                    'targetPhone'  => $suratLog->data['whatsapp'],
                    'letterType'   => $suratLog->label,
                    'letterNumber' => $suratLog->nomor_surat,
                    'downloadUrl'  => route('service.persuratan.riwayat'),
                ]);
            } catch (\Throwable $e) {
                Log::error('[LetterAdminController] WhatsApp approve notification failed: ' . $e->getMessage());
            }
        }

        return redirect()
            ->route('admin.persuratan.show', $suratLog)
            ->with('success', 'Letter request has been approved and the letter number has been issued successfully.');
    }

    /**
     * Reject the letter request with admin reason.
     */
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

        // Notify applicant via WhatsApp if phone number is available
        if (!empty($suratLog->data['whatsapp'])) {
            try {
                WhatsApp::sendLetterRejected([
                    'name'        => $suratLog->user?->name ?: ($suratLog->data['nama'] ?? 'Pemohon'),
                    'targetPhone' => $suratLog->data['whatsapp'],
                    'letterType'  => $suratLog->label,
                    'reason'      => $request->catatan_admin,
                ]);
            } catch (\Throwable $e) {
                Log::error('[LetterAdminController] WhatsApp reject notification failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Letter request has been rejected.');
    }

    /**
     * Download the official approved PDF from admin panel.
     */
    public function download(SuratLog $suratLog)
    {
        abort_if(!$suratLog->isApproved(), 403, 'Surat belum disetujui.');

        abort_if(
            empty($suratLog->filename) || $suratLog->nomor_surat === '-',
            404,
            'Dokumen belum tersedia.'
        );

        return $this->pdfService->downloadApproved($suratLog);
    }

    /**
     * Download sample ZIP package containing all template layouts.
     */
    public function downloadExampleTemplates()
    {
        return $this->pdfService->downloadExampleTemplates();
    }

    /**
     * Delete a single letter request record (Superadmin only).
     */
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

    /**
     * Bulk delete letter request records.
     */
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
}