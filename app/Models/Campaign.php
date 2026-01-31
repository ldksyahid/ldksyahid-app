<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;
use App\Http\Controllers\LibraryFunctionController as LFC;
use App\Models\Donation;
use App\Services\GoogleDrive;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;

class Campaign extends Model
{
    use HasFactory, UsesUuid;
    protected $guarded =[];

    protected static array $allowedSorts = [
        'judul',
        'kategori',
        'deadline',
        'created_at',
    ];

    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No campaigns found',
            'emptyIcon' => 'fa-hand-holding-heart',
            'colspan' => 7,
            'columns' => [
                [
                    'key' => 'judul',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'kategori',
                    'type' => 'text',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'target_biaya',
                    'type' => 'text',
                    'class' => 'text-center',
                    'formatter' => 'rupiah',
                ],
                [
                    'key' => 'deadline',
                    'type' => 'date',
                    'class' => 'text-center',
                    'dateFormat' => 'dddd, DD MMMM YYYY',
                ],
            ],
            'actions' => [
                'view' => [
                    'enabled' => true,
                    'route' => 'admin.service.preview.campaign',
                    'routeKey' => 'id',
                ],
                'edit' => [
                    'enabled' => true,
                    'type' => 'link',
                    'route' => 'admin.service.edit.campaign',
                    'routeKey' => 'id',
                ],
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-campaign-btn',
                ],
            ],
        ];
    }

    public static function getCategoryOptions(): array
    {
        return self::select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori', 'kategori')
            ->filter()
            ->toArray();
    }

    public static function searchAdminCampaigns(Request $request)
    {
        $query = self::query();

        if ($request->filled('judul')) {
            $query->where('judul', 'like', '%' . $request->judul . '%');
        }

        if ($request->filled('target_biaya')) {
            $query->where('target_biaya', 'like', '%' . $request->target_biaya . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('deadline')) {
            $dates = explode(' - ', $request->deadline);
            if (count($dates) == 2) {
                try {
                    $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('deadline', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    // Invalid date format, skip filter
                }
            }
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        if (!in_array($sortBy, static::$allowedSorts)) {
            $sortBy = 'created_at';
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate(15)->appends($request->query());
    }

    public static function bulkDeleteCampaigns(array $ids): int
    {
        $campaigns = self::whereIn('id', $ids)->get();
        $gdriveService = new GoogleDrive('1w48iZmjPCkYwVUL26zIj8fBIX37OMaGT');

        foreach ($campaigns as $campaign) {
            if (!empty($campaign->gdrive_id)) {
                $gdriveService->deleteImage($campaign->gdrive_id);
            }
            if (!empty($campaign->gdrive_id_1)) {
                $gdriveService->deleteImage($campaign->gdrive_id_1);
            }
            Donation::where('campaign_id', $campaign->id)->delete();
        }

        return self::whereIn('id', $ids)->delete();
    }

    public static function getCampaigns()
    {
        return self::orderBy('created_at', 'desc')->with("donation")->get();
    }

    public static function createCampaign($requestData, $provinsi, $kota, $targetBiaya, $uploadResultPoster, $uploadResultLogoPic)
    {
        return self::create([
            'judul' => $requestData['judul'],
            'kategori' => $requestData['kategori'],
            'link' => $requestData['link'],
            'provinsi' => $provinsi,
            'kota' => $kota,
            'target_biaya' => $targetBiaya,
            'cerita' => $requestData['cerita'],
            'kabar_terbaru' => $requestData['kabar_terbaru'],
            'deadline' => $requestData['deadline'],
            'tujuan' => $requestData['tujuan'],
            'poster' => !empty($uploadResultPoster['fileName']) ? $uploadResultPoster['fileName'] : null,
            'gdrive_id' => !empty($uploadResultPoster['gdriveID']) ? $uploadResultPoster['gdriveID'] : null,
            'logo_pj' => !empty($uploadResultLogoPic['fileName']) ? $uploadResultLogoPic['fileName'] : null,
            'gdrive_id_1' => !empty($uploadResultLogoPic['gdriveID']) ? $uploadResultLogoPic['gdriveID'] : null,
            'nama_pj' => $requestData['nama_pj'],
            'telp_pj' => $requestData['telp_pj'],
            'link_pj' => $requestData['link_pj'],
        ]);
    }



    public static function updateCampaign($id, $requestData, $provinsi, $kota, $target_biaya)
    {
        $campaign = Campaign::find($id);

        if ($campaign) {
            $target_biaya = LFC::replaceamount($requestData['target_biaya']);
            $provinsi = ucwords(strtolower($requestData['provinsi']));
            $city = City::where('id', $requestData['kota'])->first();

            if ($city != null) {
                $kota = ucwords(strtolower($city->name));
            } else {
                $kota = $requestData['kota'];
            }

            $campaign->judul = $requestData['judul'];
            $campaign->kategori = $requestData['kategori'];
            $campaign->link = $requestData['link'];
            $campaign->provinsi = $provinsi;
            $campaign->kota = $kota;
            $campaign->target_biaya = $target_biaya;
            $campaign->cerita = $requestData['cerita'];
            $campaign->kabar_terbaru = $requestData['kabar_terbaru'];
            $campaign->deadline = $requestData['deadline'];
            $campaign->tujuan = $requestData['tujuan'];
            $campaign->nama_pj = $requestData['nama_pj'];
            $campaign->telp_pj = $requestData['telp_pj'];
            $campaign->link_pj = $requestData['link_pj'];

            $campaign->save();
        }
    }

    public static function deleteCampaign($id)
    {
        $campaign = Campaign::find($id);

        if ($campaign) {

            $donations = Donation::where('campaign_id', $campaign->id)->get();
            foreach ($donations as $donation) {
                $donation->delete();
            }

            $campaign->delete();
        }
    }

    public static function getDataDonationCampaignByLink($link)
    {
        return self::where('link', $link)
            ->with(['donation' => function ($query) {
                $query->orderBy('created_at', 'DESC');
            }])
            ->first();
    }

    public static function getDataDonationCampaignById($id)
    {
        return self::where('id',$id)->with(['donation' => function ($q){
            $q->orderBy('created_at', 'DESC');
        }])->first();
    }

    public function donation() {
        return $this->hasMany('App\Models\Donation','campaign_id');
    }

}
