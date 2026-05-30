<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;
use App\Http\Controllers\LibraryFunctionController as LFC;
use App\Services\GoogleDrive;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;

class Campaign extends Model
{
    use HasFactory, UsesUuid;

    protected $guarded = [];

    protected static array $allowedSorts = [
        'judul',
        'kategori',
        'deadline',
        'created_at',
    ];

    /* ================================================================
       RELATIONSHIPS
       ================================================================ */

    public function donation()
    {
        return $this->hasMany(Donation::class, 'campaign_id');
    }

    /* ================================================================
       TABLE CONFIG & OPTIONS
       ================================================================ */

    public static function getTableConfig(): array
    {
        return [
            'idKey'        => 'id',
            'emptyMessage' => 'No campaigns found',
            'emptyIcon'    => 'fa-hand-holding-heart',
            'colspan'      => 7,
            'columns'      => [
                ['key' => 'judul',       'type' => 'text', 'class' => 'text-start'],
                ['key' => 'kategori',    'type' => 'text', 'class' => 'text-center'],
                ['key' => 'target_biaya','type' => 'text', 'class' => 'text-center', 'formatter' => 'rupiah'],
                ['key' => 'deadline',    'type' => 'date', 'class' => 'text-center', 'dateFormat' => 'dddd, DD MMMM YYYY'],
            ],
            'actions' => [
                'view'   => ['enabled' => true, 'route' => 'admin.service.preview.campaign', 'routeKey' => 'id'],
                'edit'   => ['enabled' => true, 'type' => 'link', 'route' => 'admin.service.edit.campaign', 'routeKey' => 'id'],
                'delete' => ['enabled' => true, 'btnClass' => 'delete-campaign-btn'],
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

    public static function getStatusOptions(): array
    {
        return [
            'aktif'    => 'Aktif',
            'berakhir' => 'Berakhir',
        ];
    }

    public static function getOrganizerOptions(): array
    {
        $rows = self::select('nama_pj')->distinct()->orderByRaw('nama_pj IS NULL ASC')->orderBy('nama_pj')->pluck('nama_pj');
        $options = [];
        foreach ($rows as $val) {
            $key            = $val ?? '__ldk__';
            $options[$key]  = $val ?? 'UKM LDK Syahid';
        }
        return $options;
    }

    /* ================================================================
       QUERIES
       ================================================================ */

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
            if (count($dates) === 2) {
                try {
                    $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[0]))->startOfDay();
                    $endDate   = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('deadline', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    // Invalid date format — skip
                }
            }
        }

        $sortBy    = in_array($request->input('sort_by', 'created_at'), static::$allowedSorts)
                        ? $request->input('sort_by', 'created_at')
                        : 'created_at';
        $sortOrder = $request->input('sort_order', 'desc') === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($sortBy, $sortOrder)->paginate(15)->appends($request->query());
    }

    public static function getDataDonationCampaignByLink(string $link)
    {
        return self::where('link', $link)
            ->with(['donation' => fn ($q) => $q->orderBy('created_at', 'DESC')])
            ->first();
    }

    public static function getDataDonationCampaignById(string $id)
    {
        return self::where('id', $id)
            ->with(['donation' => fn ($q) => $q->orderBy('created_at', 'DESC')])
            ->first();
    }

    /* ================================================================
       MUTATIONS
       ================================================================ */

    /**
     * Create a new campaign. All city/province/amount formatting is
     * handled here so the controller stays thin.
     */
    public static function createCampaign(array $requestData, array $uploadResultPoster, array $uploadResultLogoPic): self
    {
        $target_biaya = LFC::replaceamount($requestData['target_biaya']);
        $provinsi     = ucwords(strtolower($requestData['provinsi']));
        $city         = City::find($requestData['kota']);
        $kota         = $city ? ucwords(strtolower($city->name)) : $requestData['kota'];

        return self::create([
            'judul'       => $requestData['judul'],
            'kategori'    => $requestData['kategori'],
            'link'        => $requestData['link'],
            'provinsi'    => $provinsi,
            'kota'        => $kota,
            'target_biaya'=> $target_biaya,
            'cerita'      => $requestData['cerita'],
            'kabar_terbaru' => $requestData['kabar_terbaru'],
            'deadline'    => $requestData['deadline'],
            'tujuan'      => $requestData['tujuan'],
            'poster'      => $uploadResultPoster['fileName']  ?? null,
            'gdrive_id'   => $uploadResultPoster['gdriveID']  ?? null,
            'logo_pj'     => $uploadResultLogoPic['fileName'] ?? null,
            'gdrive_id_1' => $uploadResultLogoPic['gdriveID'] ?? null,
            'nama_pj'     => $requestData['nama_pj'],
            'telp_pj'     => $requestData['telp_pj'],
            'link_pj'     => $requestData['link_pj'],
        ]);
    }

    /**
     * Update a campaign. Formatting/lookup is handled here.
     */
    public static function updateCampaign(string $id, array $requestData): ?self
    {
        $campaign = self::find($id);
        if (!$campaign) {
            return null;
        }

        $target_biaya = LFC::replaceamount($requestData['target_biaya']);
        $provinsi     = ucwords(strtolower($requestData['provinsi']));
        $city         = City::find($requestData['kota']);
        $kota         = $city ? ucwords(strtolower($city->name)) : $requestData['kota'];

        $campaign->fill([
            'judul'         => $requestData['judul'],
            'kategori'      => $requestData['kategori'],
            'link'          => $requestData['link'],
            'provinsi'      => $provinsi,
            'kota'          => $kota,
            'target_biaya'  => $target_biaya,
            'cerita'        => $requestData['cerita'],
            'kabar_terbaru' => $requestData['kabar_terbaru'],
            'deadline'      => $requestData['deadline'],
            'tujuan'        => $requestData['tujuan'],
            'nama_pj'       => $requestData['nama_pj'],
            'telp_pj'       => $requestData['telp_pj'],
            'link_pj'       => $requestData['link_pj'],
        ])->save();

        return $campaign;
    }

    public static function deleteCampaign(string $id): void
    {
        $campaign = self::find($id);
        if (!$campaign) {
            return;
        }

        // Bulk-delete related donations, then the campaign
        Donation::where('campaign_id', $campaign->id)->delete();
        $campaign->delete();
    }

    public static function bulkDeleteCampaigns(array $ids): int
    {
        $campaigns    = self::whereIn('id', $ids)->get();
        $gdriveService = new GoogleDrive('1w48iZmjPCkYwVUL26zIj8fBIX37OMaGT');

        foreach ($campaigns as $campaign) {
            if ($campaign->gdrive_id)   $gdriveService->deleteImage($campaign->gdrive_id);
            if ($campaign->gdrive_id_1) $gdriveService->deleteImage($campaign->gdrive_id_1);

            Donation::where('campaign_id', $campaign->id)->delete();
        }

        return self::whereIn('id', $ids)->delete();
    }
}
