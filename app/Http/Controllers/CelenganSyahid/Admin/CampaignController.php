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
        try {
            $gdriveService = new GoogleDrive($this->pathCampaignsGDrive);

            $fileNamePoster = time() . '_poster_' . $request->file('poster')->getClientOriginalName();
            $uploadResultPoster = $gdriveService->uploadImage(
                $request->file('poster'),
                $fileNamePoster,
                $this->pathCampaignsGDrive . '/' . $fileNamePoster
            );

            $uploadResultLogoPic = [];
            if ($request->hasFile('logo_pj')) {
                $fileNameLogo = time() . '_logo-pic_' . $request->file('logo_pj')->getClientOriginalName();
                $uploadResultLogoPic = $gdriveService->uploadImage(
                    $request->file('logo_pj'),
                    $fileNameLogo,
                    $this->pathCampaignsGDrive . '/' . $fileNameLogo
                );
            }

            $campaign = Campaign::createCampaign($request->all(), $uploadResultPoster, $uploadResultLogoPic);

            CelsyahidAuditLog::record('campaign.create', 'campaign', $campaign->id, 'Created campaign: ' . $request->input('judul'));

            Alert::success('Success', 'Campaign has been uploaded!');
        } catch (\Exception $e) {
            Log::error('storeAdminCampaign: ' . $e->getMessage());
            Alert::error('Error', 'Gagal menyimpan campaign: ' . $e->getMessage());
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
            Alert::error('Error', 'Gagal memperbarui campaign: ' . $e->getMessage());
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

    public function financeAdminCampaign(string $id)
    {
        $campaign = Campaign::findOrFail($id);
        $balance  = $campaign->getBalanceSummary();

        $withdrawals = Withdrawal::where('campaign_id', $id)
            ->with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

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
