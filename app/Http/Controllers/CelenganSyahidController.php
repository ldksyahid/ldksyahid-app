<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\LibraryFunctionController as LFC;
use App\Models\Campaign;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Illuminate\Support\Facades\Hash;

class CelenganSyahidController extends Controller
{
    public function index()
    {
        // $postevent = Event::orderBy('dateevent','desc')->get();
        return view('LandingPageView.LandingPageViewLayanan.LandingPageViewLayananCelenganSyahid.landingpageview-layanan-celengansyahid',["title" => "Layanan"]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($nameCampaign)
    {
        return view('LandingPageView.LandingPageViewLayanan.LandingPageViewLayananCelenganSyahid.landingpageview-layanan-celengansyahid-show',["title" => "Layanan"]);
    }

    public function donasiSekarang($nameCampaign)
    {
        return view('LandingPageView.LandingPageViewLayanan.LandingPageViewLayananCelenganSyahid.landingpageview-layanan-celengansyahid-show-donasi-sekarang',["title" => "Layanan"]);
    }

    public function status($nameCampaign)
    {
        return view('LandingPageView.LandingPageViewLayanan.LandingPageViewLayananCelenganSyahid.landingpageview-layanan-celengansyahid-show-donasi-sekarang-status',["title" => "Layanan"]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function indexAdminCampaign()
    {
        $postcampaign = Campaign::orderBy('created_at','desc')->get();
        return view('AdminPageView.AdminPageViewService.AdminPageViewServiceCelenganSyahid.AdminPageViewServiceCelenganSyahidCampaign.adminpageviewservicecelsyahcamp',compact('postcampaign'), ["title" => "Celengan Syahid"]);
    }

    public function createAdminCampaign()
    {
        $provinces = Province::pluck('name', 'id');
        $cities = City::pluck('name', 'id');

        return view('AdminPageView.AdminPageViewService.AdminPageViewServiceCelenganSyahid.AdminPageViewServiceCelenganSyahidCampaign.adminpageviewservicecelsyahcampcreate', compact(['provinces', 'cities']),["title" => "Celengan Syahid"]);
    }

    public function storeAdminCampaign(Request $request)
    {
        $target_biaya = LFC::replaceamount($request['target_biaya']);
        $provinsi = ucwords(strtolower($request["provinsi"]));
        $kota = ucwords(strtolower($request["kota"]));

        $filename_poster = time().$request->file('poster')->getClientOriginalName();
        $path_poster = $request->file('poster')->storeAs('Images/uploads/campaigns',$filename_poster);

        $path_logo_pj = null;
        if ($request->logo_pj != null) {
            $filename_logo_pj = time().$request->file('logo_pj')->getClientOriginalName();
            $path_logo_pj = $request->file('logo_pj')->storeAs('Images/uploads/logos',$filename_logo_pj);
        }

        // dd($kota);

        $postCampaign = Campaign::create([
            "judul" => $request['judul'],
            "kategori" => $request["kategori"],
            "link" => $request["link"],
            "provinsi" => $provinsi,
            "kota" => $kota,
            "target_biaya" => $target_biaya,
            "cerita" => $request["cerita"],
            "deadline" => $request["deadline"],
            "tujuan" => $request["tujuan"],
            "poster" => $path_poster,
            "logo_pj" => $path_logo_pj,
            "nama_pj" => $request["nama_pj"],
            "telp_pj" => $request["telp_pj"],
            "link_pj" => $request["link_pj"],
        ]);

        Alert::success('Success', 'Campaign has been uploaded !');
        return redirect('/admin/service/celengansyahid/campaigns');
    }

    public function destroyAdminCampaign($id){
        // hapus file
        $gambar = Campaign::where('id',$id)->first();
        File::delete($gambar->poster);
        File::delete($gambar->logo_pj);

        // hapus data
        Campaign    ::where('id',$id)->delete();
        return redirect()->back();
    }
    // public function storeKota(request $request)
    // {
    //     var_dump($request->get('province_id'));
    //     $cities = City::where('province_id', $request->get('id'))
    //         ->pluck('name', 'id');
    //     $cities = City::pluck('name', $request->get('province_id'));
    //     return response()->json($cities);
    // }
}

