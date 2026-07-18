<?php

namespace App\Http\Controllers\CelenganSyahid\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LibraryFunctionController as LFC;
use App\Models\Campaign;
use App\Models\CelsyahidAuditLog;
use App\Models\Withdrawal;
use App\Services\BisaTopup;
use App\Services\GoogleDrive;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Province;
use RealRashid\SweetAlert\Facades\Alert;

class CampaignController extends Controller
{
    public $pathCampaignsGDrive = '1w48iZmjPCkYwVUL26zIj8fBIX37OMaGT';

    public function indexAdminCampaign(Request $request)
    {
        $items       = Campaign::searchAdminCampaigns($request);
        $tableConfig = Campaign::getTableConfig();

        $items->getCollection()->transform(function ($campaign) {
            $campaign->target_biaya  = LFC::formatRupiah($campaign->target_biaya);
            $campaign->has_donations = $campaign->donation_count > 0;
            return $campaign;
        });

        $categoryOptions = Campaign::getCategoryOptions();

        if ($request->ajax()) {
            return response()->json([
                'tableBody'  => view('components.admin-index.index-table', compact('items', 'tableConfig'))->render(),
                'pagination' => $items->appends($request->query())->links()->render(),
                'total'      => $items->total(),
                'from'       => $items->firstItem(),
                'to'         => $items->lastItem(),
            ]);
        }

        return view('admin-page.service.celengan-syahid.campaign.index',
            compact('items', 'tableConfig', 'categoryOptions'))
            ->with('title', 'Celengan Syahid');
    }

    public function createAdminCampaign()
    {
        $provinces = Province::pluck('name', 'id');
        return view('admin-page.service.celengan-syahid.campaign.create',
            compact('provinces'), ['title' => 'Celengan Syahid']);
    }

    public function storeAdminCampaign(Request $request)
    {
        $reqId = strtoupper(substr(uniqid('CAMP-'), 0, 12));
        Log::info("[{$reqId}] storeAdminCampaign START — link={$request->input('link')} ip={$request->ip()} user=" . optional(auth()->user())->email);

        // Idempotency guard: if this link was successfully created in the last 5 minutes
        // (by any user), treat as a duplicate submission and redirect as success.
        $recentCampaign = Campaign::where('link', $request->input('link'))
            ->where('created_at', '>=', now()->subMinutes(5))
            ->first();

        if ($recentCampaign) {
            Log::info("[{$reqId}] Idempotency: link={$request->input('link')} already created at {$recentCampaign->created_at}, treating as success");
            Alert::success('Success', 'Campaign has been uploaded!');
            return redirect('/admin/celengan-syahid/campaigns');
        }

        $request->validate([
            'judul'        => 'required|string|max:255',
            'link'         => 'required|string|max:255|unique:campaigns,link',
            'kategori'     => 'required|string',
            'target_biaya' => 'required',
            'cerita'       => 'required',
            'tujuan'       => 'required',
            'deadline'     => 'required|date',
            'telp_pj'      => 'required|string',
            'poster'       => 'required|file|mimes:jpg,jpeg,png|max:5120',
        ], [
            'link.unique' => 'This campaign link is already taken. Please choose a different link.',
        ]);

        Log::info("[{$reqId}] Validation passed");

        try {
            $gdriveService = new GoogleDrive($this->pathCampaignsGDrive);

            Log::info("[{$reqId}] GDrive poster upload START");
            $fileNamePoster = time() . '_poster_' . $request->file('poster')->getClientOriginalName();
            $uploadResultPoster = $gdriveService->uploadImage(
                $request->file('poster'),
                $fileNamePoster,
                $this->pathCampaignsGDrive . '/' . $fileNamePoster
            );
            Log::info("[{$reqId}] GDrive poster upload DONE — gdriveID=" . ($uploadResultPoster['gdriveID'] ?? 'null'));

            $uploadResultLogoPic = [];
            if ($request->hasFile('logo_pj')) {
                Log::info("[{$reqId}] GDrive logo upload START");
                $fileNameLogo = time() . '_logo-pic_' . $request->file('logo_pj')->getClientOriginalName();
                $uploadResultLogoPic = $gdriveService->uploadImage(
                    $request->file('logo_pj'),
                    $fileNameLogo,
                    $this->pathCampaignsGDrive . '/' . $fileNameLogo
                );
                Log::info("[{$reqId}] GDrive logo upload DONE");
            }

            Log::info("[{$reqId}] DB insert START");
            $campaign = Campaign::createCampaign($request->all(), $uploadResultPoster, $uploadResultLogoPic);
            Log::info("[{$reqId}] DB insert DONE — campaign_id={$campaign->id}");

            CelsyahidAuditLog::record('campaign.create', 'campaign', $campaign->id, 'Created campaign: ' . $request->input('judul'));

            Alert::success('Success', 'Campaign has been uploaded!');
            Log::info("[{$reqId}] storeAdminCampaign SUCCESS");
        } catch (\Exception $e) {
            Log::error("[{$reqId}] storeAdminCampaign FAILED — " . $e->getMessage());
            Alert::error('Error', 'Failed to save campaign. Please try again or contact the administrator.');
        }

        return redirect('/admin/celengan-syahid/campaigns');
    }

    public function editAdminCampaign($id)
    {
        $province = Province::pluck('name', 'id');
        $data     = Campaign::findOrFail($id);
        return view('admin-page.service.celengan-syahid.campaign.update',
            compact('province', 'data'), ['title' => 'Celengan Syahid']);
    }

    public function updateAdminCampaign(Request $request, $id)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'link'     => 'required|string|max:255|unique:campaigns,link,' . $id,
            'kategori' => 'required|string',
            'deadline' => 'nullable|date',
            'poster'   => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ], [
            'link.unique' => 'This campaign link is already taken. Please choose a different link.',
        ]);

        try {
            $gdriveService = new GoogleDrive($this->pathCampaignsGDrive);
            $campaign      = Campaign::findOrFail($id);

            if ($request->hasFile('poster')) {
                $fileNamePoster = time() . '_poster_' . $request->file('poster')->getClientOriginalName();
                $uploaded = $gdriveService->uploadImage(
                    $request->file('poster'),
                    $fileNamePoster,
                    $this->pathCampaignsGDrive . '/' . $fileNamePoster
                );
                if (!empty($uploaded)) {
                    if ($campaign->gdrive_id) {
                        $gdriveService->deleteImage($campaign->gdrive_id);
                    }
                    $campaign->update([
                        'poster'    => $uploaded['fileName'],
                        'gdrive_id' => $uploaded['gdriveID'],
                    ]);
                }
            }

            if ($request->hasFile('logo_pj')) {
                $fileNameLogo = time() . '_logo-pic_' . $request->file('logo_pj')->getClientOriginalName();
                $uploaded = $gdriveService->uploadImage(
                    $request->file('logo_pj'),
                    $fileNameLogo,
                    $this->pathCampaignsGDrive . '/' . $fileNameLogo
                );
                if (!empty($uploaded)) {
                    if ($campaign->gdrive_id_1) {
                        $gdriveService->deleteImage($campaign->gdrive_id_1);
                    }
                    $campaign->update([
                        'logo_pj'    => $uploaded['fileName'],
                        'gdrive_id_1' => $uploaded['gdriveID'],
                    ]);
                }
            }

            Campaign::updateCampaign($id, $request->all());

            CelsyahidAuditLog::record('campaign.update', 'campaign', $id, 'Updated campaign: ' . $request->input('judul'));

            toast('Campaign has been updated!', 'success')->autoClose(1500)->width('400px');
        } catch (\Exception $e) {
            Log::error('updateAdminCampaign: ' . $e->getMessage());
            Alert::error('Error', 'Failed to update campaign. Please try again or contact the administrator.');
        }

        return redirect('/admin/celengan-syahid/campaigns');
    }

    public function previewAdminCampaign($id)
    {
        $province = Province::pluck('name', 'id');
        $data     = Campaign::getDataDonationCampaignById($id);
        return view('admin-page.service.celengan-syahid.campaign.view', [
            'data'     => $data,
            'title'    => 'Celengan Syahid',
            'province' => $province,
        ]);
    }

    public function financeAdminCampaign(\Illuminate\Http\Request $request, string $id)
    {
        $campaign = Campaign::findOrFail($id);

        $withdrawals = Withdrawal::where('campaign_id', $id)
            ->with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'tableBody'    => view('admin-page.service.celengan-syahid.campaign.components._finance._withdrawal-rows', compact('withdrawals'))->render(),
                'total'        => $withdrawals->total(),
                'from'         => $withdrawals->firstItem() ?? 0,
                'to'           => $withdrawals->lastItem() ?? 0,
                'current_page' => $withdrawals->currentPage(),
                'last_page'    => $withdrawals->lastPage(),
            ]);
        }

        $balance  = $campaign->getBalanceSummary();

        $bisabillerBalance = Cache::remember('bisabiller_wallet_balance', 300, function () {
            return (new BisaTopup())->walletBalance();
        });

        return view('admin-page.service.celengan-syahid.campaign.finance', [
            'campaign'          => $campaign,
            'balance'           => $balance,
            'withdrawals'       => $withdrawals,
            'bisabillerBalance' => $bisabillerBalance,
            'title'             => 'Celengan Syahid',
        ]);
    }

    public function destroyAdminCampaign($id)
    {
        try {
            $gdriveService = new GoogleDrive($this->pathCampaignsGDrive);
            $campaign      = Campaign::findOrFail($id);

            if ($campaign->gdrive_id) {
                $gdriveService->deleteImage($campaign->gdrive_id);
            }
            if ($campaign->gdrive_id_1) {
                $gdriveService->deleteImage($campaign->gdrive_id_1);
            }

            Campaign::deleteCampaign($id);

            CelsyahidAuditLog::record('campaign.delete', 'campaign', $id, 'Deleted campaign: ' . $campaign->judul);

            return response()->json(['success' => true, 'message' => 'Campaign has been deleted!']);
        } catch (\Exception $e) {
            Log::error('destroyAdminCampaign: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting campaign: ' . $e->getMessage()], 500);
        }
    }

    public function bulkDeleteCampaign(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No campaigns selected for deletion'], 400);
        }

        try {
            $deleted = Campaign::bulkDeleteCampaigns($ids);
            CelsyahidAuditLog::record('campaign.bulk_delete', 'campaign', null, "Bulk deleted {$deleted} campaign(s)");
            return response()->json(['success' => true, 'message' => "{$deleted} campaign(s) have been deleted!"]);
        } catch (\Exception $e) {
            Log::error('bulkDeleteCampaign: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting campaigns: ' . $e->getMessage()], 500);
        }
    }

    public function checkLink(Request $request)
    {
        $link      = strtolower(trim($request->input('link', '')));
        $excludeId = $request->input('exclude_id'); // for edit: ignore current campaign's own link

        if (empty($link)) {
            return response()->json(['available' => false, 'message' => 'Link cannot be empty.']);
        }

        $query = Campaign::where('link', $link);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $exists = $query->exists();

        return response()->json([
            'available' => !$exists,
            'message'   => $exists ? 'This link is already taken.' : 'Link is available.',
        ]);
    }

    public function storeCity(Request $request)
    {
        $dataProvince = Province::where('name', $request->input('id'))->first();
        if (!$dataProvince) {
            return response()->json([]);
        }
        $cities = City::where('province_code', $dataProvince->code)->pluck('name', 'id');
        return response()->json($cities);
    }
}
