<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;
use App\Http\Controllers\LibraryFunctionController as LFC;
use App\Models\Donation;
use Illuminate\Support\Facades\File;
use Laravolt\Indonesia\Models\City;

class Campaign extends Model
{
    use HasFactory, UsesUuid;
    protected $guarded =[];

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
