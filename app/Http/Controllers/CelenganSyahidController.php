<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\LibraryFunctionController as LFC;
use App\Models\Campaign;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;

class CelenganSyahidController extends Controller
{
    public function indexLanding()
    {
        $postcampaign = Campaign::orderBy('created_at','desc')->get();

        return view('LandingPageView.LandingPageViewLayanan.LandingPageViewLayananCelenganSyahid.landingpageview-layanan-celengansyahid',compact('postcampaign'),["title" => "Layanan"]);
    }


    public function create()
    {
        //
    }

    public function storeDonationCampaign(Request $request)
    {
        dd($request);
    }

    public function showLanding($link)
    {
        // dd($link);
        $data = Campaign::where('link',$link)->first();
        return view('LandingPageView.LandingPageViewLayanan.LandingPageViewLayananCelenganSyahid.landingpageview-layanan-celengansyahid-show')->with([
            'data' => $data,
            "title" => "Layanan"
        ]);
    }

    public function donasiSekarang($link)
    {
        $data = Campaign::where('link',$link)->first();
        return view('LandingPageView.LandingPageViewLayanan.LandingPageViewLayananCelenganSyahid.landingpageview-layanan-celengansyahid-show-donasi-sekarang')->with([
            'data' => $data,
            "title" => "Layanan"
        ]);

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

    public function previewAdminCampaign($id)
    {
        $data = Campaign::findOrFail($id);
        return view('AdminPageView.AdminPageViewService.AdminPageViewServiceCelenganSyahid.AdminPageViewServiceCelenganSyahidCampaign.adminpageviewservicecelsyahcamppreview')->with([
            'data' => $data,
            "title" => "Celengan Syahid"
        ]);
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

        $post = Campaign::create([
            "judul" => $request['judul'],
            "kategori" => $request["kategori"],
            "link" => $request["link"],
            "provinsi" => $provinsi,
            "kota" => $kota,
            "target_biaya" => $target_biaya,
            "cerita" => $request["cerita"],
            "kabar_terbaru" => $request["kabar_terbaru"],
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

    public function editAdminCampaign($id)
    {
        $provinces = Province::pluck('name', 'id');
        $cities = City::pluck('name', 'id');
        $data = Campaign::findOrFail($id);

        // return view('AdminPageView.AdminPageViewService.AdminPageViewServiceCelenganSyahid.AdminPageViewServiceCelenganSyahidCampaign.adminpageviewservicecelsyahcampedit')->with([
        //     'data' => $data,
        //     "title" => "Celengan Syahid"
        // ]);

        return view('AdminPageView.AdminPageViewService.AdminPageViewServiceCelenganSyahid.AdminPageViewServiceCelenganSyahidCampaign.adminpageviewservicecelsyahcampedit', compact(['provinces', 'cities', 'data']),["title" => "Celengan Syahid"]);
    }

    public function updateAdminCampaign(Request $request, $id)
    {
        // dd($request);
        $target_biaya = LFC::replaceamount($request['target_biaya']);
        $provinsi = ucwords(strtolower($request["provinsi"]));
        $kota = ucwords(strtolower($request["kota"]));

        if ($request->file('poster')) {
            $filename = time().$request->file('poster')->getClientOriginalName();
            $path = $request->file('poster')->storeAs('Images/uploads/campaigns',$filename);

            // hapus file
            $gambar = Campaign::where('id',$id)->first();
            File::delete($gambar->poster);

            // upload file
            $update = Campaign::where("id", $id)-> update([
                'poster' => $path,
            ]);
        }

        if ($request->file('logo_pj')) {
            $filename = time().$request->file('logo_pj')->getClientOriginalName();
            $path = $request->file('logo_pj')->storeAs('Images/uploads/logos',$filename);

            // hapus file
            $gambar = Campaign::where('id',$id)->first();
            File::delete($gambar->logo_pj);

            // upload file
            $update = Campaign::where("id", $id)-> update([
                'logo_pj' => $path,
            ]);
        }

        $update = Campaign::where("id", $id)-> update([
            "judul" => $request['judul'],
            "kategori" => $request["kategori"],
            "link" => $request["link"],
            "provinsi" => $provinsi,
            "kota" => $kota,
            "target_biaya" => $target_biaya,
            "cerita" => $request["cerita"],
            "kabar_terbaru" => $request["kabar_terbaru"],
            "deadline" => $request["deadline"],
            "tujuan" => $request["tujuan"],
            "nama_pj" => $request["nama_pj"],
            "telp_pj" => $request["telp_pj"],
            "link_pj" => $request["link_pj"],
        ]);

        toast('Campaign has been edited !', 'success')->autoClose(1500)->width('400px');
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

