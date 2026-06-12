<?php

namespace App\Http\Controllers\CelenganSyahid\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LibraryFunctionController as LFC;
use App\Models\Campaign;
use App\Models\CelsyahidAuditLog;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    public function indexAdminDonation(Request $request)
    {
        $items       = Donation::searchAdminDonations($request);
        $tableConfig = Donation::getTableConfig();

        $campaignNames = Campaign::pluck('judul', 'id')->toArray();
        $items->getCollection()->transform(function ($donation) use ($campaignNames) {
            $donation->campaign_name = $campaignNames[$donation->campaign_id] ?? '-';
            $donation->jumlah_donasi = LFC::formatRupiah($donation->jumlah_donasi);
            return $donation;
        });

        $paymentStatusOptions = Donation::getPaymentStatusOptions();
        $campaignOptions      = Donation::getCampaignOptions();

        if ($request->ajax()) {
            return response()->json([
                'tableBody'  => view('components.admin-index.index-table', compact('items', 'tableConfig'))->render(),
                'pagination' => $items->appends($request->query())->links()->render(),
                'total'      => $items->total(),
                'from'       => $items->firstItem(),
                'to'         => $items->lastItem(),
            ]);
        }

        return view('admin-page.service.celengan-syahid.donation.index',
            compact('items', 'tableConfig', 'paymentStatusOptions', 'campaignOptions'))
            ->with('title', 'Celengan Syahid');
    }

    public function showAdminDonation($id)
    {
        $donation = Donation::with('campaign')->findOrFail($id);

        return view('admin-page.service.celengan-syahid.donation.show', [
            'donation' => $donation,
            'campaign' => $donation->campaign,
            'title'    => 'Celengan Syahid',
        ]);
    }

    /**
     * Stream all donations (matching the current admin filters) as a CSV file.
     */
    public function exportDonations(Request $request)
    {
        $campaignNames = Campaign::pluck('judul', 'id')->toArray();
        $filename      = 'donations-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->streamDownload(function () use ($request, $campaignNames) {
            $out = fopen('php://output', 'w');
            // UTF-8 BOM so Excel renders Rupiah/diacritics correctly
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, [
                'Tanggal', 'Nama Donatur', 'Anonim', 'Email', 'No. Telp', 'Usia',
                'Domisili', 'Pekerjaan', 'Campaign', 'Jumlah Donasi', 'Status',
                'Metode Pembayaran', 'Merchant', 'Biaya Admin', 'Total Tagihan', 'Doc No',
            ]);

            Donation::applyAdminFilters(Donation::query(), $request)
                ->orderBy('created_at', 'desc')
                ->chunk(500, function ($rows) use ($out, $campaignNames) {
                    foreach ($rows as $d) {
                        fputcsv($out, [
                            optional($d->created_at)->format('Y-m-d H:i'),
                            $d->nama_donatur,
                            $d->is_anonymous ? 'Ya' : 'Tidak',
                            $d->email_donatur,
                            $d->no_telp_donatur,
                            $d->usia,
                            $d->domisili,
                            $d->pekerjaan,
                            $campaignNames[$d->campaign_id] ?? '-',
                            $d->jumlah_donasi,
                            $d->payment_status,
                            $d->metode_pembayaran,
                            $d->nama_merchant,
                            $d->biaya_admin,
                            $d->total_tagihan,
                            $d->doc_no,
                        ]);
                    }
                });

            fclose($out);
        }, $filename, $headers);
    }

    public function destroyAdminDonation($id)
    {
        try {
            Donation::deleteDonation($id);
            CelsyahidAuditLog::record('donation.delete', 'donation', $id, 'Deleted donation');
            return response()->json(['success' => true, 'message' => 'Donation has been deleted!']);
        } catch (\Exception $e) {
            Log::error('destroyAdminDonation: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting donation: ' . $e->getMessage()], 500);
        }
    }

    public function bulkDeleteDonation(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No donations selected for deletion'], 400);
        }

        try {
            $deleted = Donation::bulkDeleteDonations($ids);
            CelsyahidAuditLog::record('donation.bulk_delete', 'donation', null, "Bulk deleted {$deleted} donation(s)");
            return response()->json(['success' => true, 'message' => "{$deleted} donation(s) have been deleted!"]);
        } catch (\Exception $e) {
            Log::error('bulkDeleteDonation: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting donations: ' . $e->getMessage()], 500);
        }
    }
}
