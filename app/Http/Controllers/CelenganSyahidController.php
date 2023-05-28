<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\LibraryFunctionController as LFC;
use App\Models\Campaign;
use App\Models\Donation;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class CelenganSyahidController extends Controller
{
    public function indexLanding()
    {
        $postcampaign = Campaign::orderBy('created_at','desc')->with("donation")->get();
        return view('landing-page.service.celengan-syahid.index',compact(['postcampaign']),["title" => "Layanan"]);
    }

    public function storeDonationCampaign(Request $request)
    {

        $jumlah_donasi = (int) LFC::replaceamount($request['jumlah_donasi']);

        $secret_key = 'Basic '.config('xendit.key_auth');
        $external_id = Str::random(10);

        if ($jumlah_donasi < 10000) {
            Alert::warning('Maaf!', 'Silahkan masukkan donasi minimal Rp10.000');
            return Redirect::back();
        }
        elseif($request['g-recaptcha-response'] == null){
            Alert::warning('Maaf!', 'Silahkan verifikasi Captcha terlebih dahulu');
            return Redirect::back();
        }
        else
        {
            $data_request = Http::withHeaders([
                'Authorization' => $secret_key
            ])->post('https://api.xendit.co/v2/invoices', [
                'external_id' => $external_id,
                'amount' => $jumlah_donasi
            ]);

            $response = $data_request->object();


            $expired_date = Carbon::parse($response->expiry_date)->format('Y-m-d H:i:s');

            $postDonation = Donation::create([
                'doc_no' => $external_id,
                "jumlah_donasi" => $jumlah_donasi,
                "nama_donatur" => $request['nama_donatur'],
                "email_donatur" => $request['email_donatur'],
                "no_telp_donatur" => $request['no_telp_donatur'],
                "pesan_donatur" => $request['pesan_donatur'],
                "captcha" => $request['g-recaptcha-response'],
                "campaign_id" => $request['postdonation'],
                'payment_status' => $response->status,
                'payment_link' => $response->invoice_url
            ]);
            return Redirect::route('service.celengansyahid.detail.donasisekarang.status', array('link' => $request['linkcampaign'],'id' => $postDonation->id));
        }
    }

    public function openPaymentGateway($id)
    {
        $data = Donation::where('id',$id)->first();

        return redirect()->away($data->payment_link);
    }

    public function callbackDonation()
    {
        $data = request()->all();
        $status = $data['status'];
        $external_id = $data['external_id'];
        Donation::where('doc_no', $external_id)->update([
            'payment_status' => $status
        ]);
        return response()->json($data);
    }

    public function showLanding($link)
    {
        $data = Campaign::where('link',$link)->with(['donation' => function ($q){
            $q->orderBy('created_at', 'DESC');
        }])->first();

        return view('landing-page.service.celengan-syahid.detail')->with([
            'data' => $data,
            "title" => "Layanan"
        ]);
    }

    public function donasiSekarang($link)
    {
        $data = Campaign::where('link',$link)->first();
        return view('landing-page.service.celengan-syahid.donate-now')->with([
            'data' => $data,
            "title" => "Layanan"
        ]);
    }

    public function statusDonasi($link, $id)
    {
        $data = Donation::where('id',$id)->first();
        $campaign = Campaign::where('link', $link)->first();

        return view('landing-page.service.celengan-syahid.donation-state')->with([
            'data' => $data,
            "title" => "Layanan",
            'campaign' => $campaign,
        ]);
    }

    public function savePaymentDonation($link, $id)
    {
        $donation = Donation::where('id',$id)->first();
        $campaign = Campaign::where('link', $link)->first();

        $pdf = PDF::loadView('print-request.donation-proof', compact(['donation', 'campaign']));
        return $pdf->setPaper('a4')->stream('Bukti Pembayaran Donasi'." - ".$donation->id.".pdf");
    }

    public function indexAdminDonation()
    {
        $postDonation = Donation::orderBy('created_at','desc')->get();
        return view('admin-page.service.celengan-syahid.donation.index',compact('postDonation'), ["title" => "Celengan Syahid"]);
    }

    public function destroyAdminDonation($id){
        Donation::where('id',$id)->delete();
        return redirect()->back();
    }

    public function indexAdminCampaign()
    {
        $postcampaign = Campaign::orderBy('created_at','desc')->get();
        return view('admin-page.service.celengan-syahid.campaign.index',compact('postcampaign'), ["title" => "Celengan Syahid"]);
    }

    public function createAdminCampaign()
    {
        $provinces = Province::pluck('name', 'id');

        return view('admin-page.service.celengan-syahid.campaign.create', compact(['provinces']),["title" => "Celengan Syahid"]);
    }

    public function previewAdminCampaign($id)
    {
        $province = Province::pluck('name', 'id');
        $data = Campaign::where('id',$id)->with(['donation' => function ($q){
            $q->orderBy('created_at', 'DESC');
        }])->first();

        return view('admin-page.service.celengan-syahid.campaign.view')->with([
            'data' => $data,
            "title" => "Celengan Syahid",
            "province" => $province
        ]);
    }

    public function storeAdminCampaign(Request $request)
    {

        $target_biaya = LFC::replaceamount($request['target_biaya']);
        $provinsi = ucwords(strtolower($request["provinsi"]));

        $city = City::where('id', $request['kota'])->first();
        $kota = ucwords(strtolower($city->name));

        $filename_poster = time().$request->file('poster')->getClientOriginalName();
        $path_poster = $request->file('poster')->storeAs('Images/uploads/campaigns',$filename_poster);

        $path_logo_pj = null;
        if ($request->logo_pj != null) {
            $filename_logo_pj = time().$request->file('logo_pj')->getClientOriginalName();
            $path_logo_pj = $request->file('logo_pj')->storeAs('Images/uploads/logos',$filename_logo_pj);
        }

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
        $province = Province::pluck('name', 'id');
        $data = Campaign::findOrFail($id);

        return view('admin-page.service.celengan-syahid.campaign.update', compact(['province', 'data']),["title" => "Celengan Syahid"]);
    }

    public function updateAdminCampaign(Request $request, $id)
    {
        $target_biaya = LFC::replaceamount($request['target_biaya']);
        $provinsi = ucwords(strtolower($request["provinsi"]));

        $city = City::where('id', $request['kota'])->first();
        if ($city != null) {
            $kota = ucwords(strtolower($city->name));
        } else {
            $kota = $request['kota'];
        }

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

        toast('Campaign has been updated !', 'success')->autoClose(1500)->width('400px');
        return redirect('/admin/service/celengansyahid/campaigns');
    }

    public function destroyAdminCampaign($id){
        // hapus file
        $dataCampaign = Campaign::where('id',$id)->first();

        if ($dataCampaign->poster != null) {
            File::delete($dataCampaign->poster);
        }

        if ($dataCampaign->logo_pj) {
            File::delete($dataCampaign->logo_pj);
        }

        // hapus data donation
        $dataDonation = Donation::where('campaign_id',$dataCampaign->id)->first();
        if ($dataDonation != null) {
            $campaignID = $dataDonation->campaign_id;
            Donation::where('campaign_id',$campaignID)->delete();
        }

        // hapus data campaign
        Campaign::where('id',$id)->delete();
        return redirect()->back();
    }

    public function storeKota(request $request)
    {
        $dataProvince = Province::where('name', $request['id'])->first();
        $codeProvince = $dataProvince->code;

        $cities = City::where('province_code', $codeProvince)->pluck('name', 'id');

        return response()->json($cities);
    }
}

