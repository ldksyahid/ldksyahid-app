<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\LibraryFunctionController as LFC;
use App\Models\Campaign;
use App\Models\Donation;
use App\Services\Xendit;
use App\Services\Wablas;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\DonationInvoice;
use App\Services\GoogleDrive;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CelenganSyahidController extends Controller
{
    public $pathCampaignsGDrive = '1w48iZmjPCkYwVUL26zIj8fBIX37OMaGT';
    
    public function indexLanding()
    {
        $postcampaign = Campaign::getCampaigns();
        return view('landing-page.service.celengan-syahid.index', compact('postcampaign'), ["title" => "Layanan"]);
    }

    public function storeDonationCampaign(Request $request)
    {
        $jumlah_donasi = (int) LFC::replaceamount($request['jumlah_donasi']);
        $external_id = Str::random(10);
        if ($jumlah_donasi < 10000) {
            Alert::warning('Maaf!', 'Silahkan masukkan donasi minimal Rp10.000');
            return Redirect::back();
        }
        else if($request['g-recaptcha-response'] == null){
            Alert::warning('Maaf!', 'Silahkan verifikasi Captcha terlebih dahulu');
            return Redirect::back();
        }
        else
        {
            $xendit_request = Xendit::postInvoice($external_id, $jumlah_donasi);
            $responseXendit = $xendit_request->object();
            $postDonation = Donation::createDonation($request, $external_id, $jumlah_donasi, $responseXendit->status, $responseXendit->invoice_url);
            $campaign = Campaign::where('link', $request['linkcampaign'])->first();
            $expiredDate = $responseXendit->expiry_date;
            $carbonDate = Carbon::parse($expiredDate)->setTimezone('Asia/Jakarta');
            $formattedDate = $carbonDate->isoFormat('dddd, D MMMM YYYY') . ' Pukul ' . $carbonDate->isoFormat('HH:mm');
            $data = [
                'donaturTelp' => $request->input('no_telp_donatur'),
                'campaignName' => $campaign['judul'],
                'linkCampaign' => $request['linkcampaign'],
                'donaturName' => $request->input('nama_donatur'),
                'donaturMessage' => $request->input('pesan_donatur'),
                'donationAmount' => $request->input('jumlah_donasi'),
                'donationID' => $postDonation->id,
                'invoiceUrl' => $responseXendit->invoice_url,
                'merchantName' => $responseXendit->merchant_name,
                'logo' => $responseXendit->merchant_profile_picture_url,
                'expiredDate' => $formattedDate,
            ];
            Wablas::sendInvoiceSimpleText($data);
            Mail::to($request->input('email_donatur'))->send(new DonationInvoice($data));
            return Redirect::route('service.celengansyahid.detail.donateNow.status', array('link' => $request['linkcampaign'],'id' => $postDonation->id));
        }
    }

    public function openPaymentGateway($id)
    {
        $data = Donation::getDonationById($id);
        return redirect()->away($data->payment_link);
    }

    public function callbackDonation()
    {
        $dataXendit = request()->all();
        $response = response()->json($dataXendit);
        $status = $dataXendit['status'];
        $external_id = $dataXendit['external_id'];
        Donation::updatePaymentStatus($external_id, $dataXendit);
        $donationData = Donation::where('doc_no', $external_id)->first();
        if ($status == 'PAID') {
            $data = [
                'donaturName' => $donationData->nama_donatur ?? null,
                'donationAmount' => $donationData->jumlah_donasi ?? 0,
                'donaturTelp' => $donationData->no_telp_donatur ?? null,
            ];
            Wablas::sendPaidSimpleText($data);
        }
        return $response;
    }

    public function showLanding($link)
    {
        $data = Campaign::getDataDonationCampaignByLink($link);
        return view('landing-page.service.celengan-syahid.detail')->with([
            'data' => $data,
            "title" => "Layanan"
        ]);
    }

    public function donateNow($link)
    {
        $data = Campaign::where('link',$link)->first();
        $cities = City::pluck('name', 'id');
        $jobs = [
            'Guru', 'Dokter', 'Pengusaha', 'Karyawan', 'Mahasiswa', 'Petani', 'TNI', 'Polisi', 'Nelayan', 'Wirausaha',
            'PNS', 'Pilot', 'Pemadam Kebakaran', 'Seniman', 'Pedagang', 'Pekerja Konstruksi', 'Penyanyi', 'Penulis', 'Desainer',
            'Montir', 'Sopir', 'Koki', 'Tukang Kayu', 'Tukang Las', 'Tukang Jahit', 'Tukang Listrik', 'Pelaut', 'Peternak', 'Konsultan',
            'Arsitek', 'Pemilik Toko', 'Programmer', 'Bidan', 'Pramugari', 'Pramugara', 'Manajer', 'Marketing', 'Bendahara', 'Admin',
            'Satpam', 'Sekretaris', 'Dosen', 'Peneliti', 'Guru Les', 'Pemandu Wisata', 'Tukang Cukur', 'Petugas Kebersihan', 'Suster',
            'Pandai Besi', 'Penjaga Toko', 'Karyawan Bank', 'Akuntan', 'Farmasi', 'Quality Assurance', 'Quality Control', 'Software Engineer',
            'Content Creator', 'Animator', 'HR Specialist', 'Data Analyst', 'Translator', 'Yoga Instructor', 'Fitness Trainer',
            'Interior Designer', 'Environmental Scientist', 'Event Planner', 'Financial Advisor', 'Travel Blogger', 'Photographer',
            'Nutritionist', 'Game Developer', 'Social Worker', 'Civil Engineer', 'Robotics Engineer', 'Ethical Hacker', 'Ethnographer',
            'Meteorologist', 'Political Analyst', 'Fashion Designer', 'Archaeologist', 'Art Therapist', 'Cryptocurrency Trader',
            'Blockchain Developer', 'Ethical Hacker', 'Marine Biologist', 'Zoologist', 'Personal Chef', 'Astronomer', 'Geologist',
            'Speech Therapist', 'Neuroscientist', 'Voice Actor', 'Film Director', 'Sound Designer', 'Ethical Hacker', 'AI Researcher',
            'Astrophysicist', 'Data Scientist', 'Climate Change Analyst', 'Wildlife Biologist', 'Forensic Scientist', 'Futurist',
            'Food Scientist', 'Neonatal Nurse', 'Cybersecurity Analyst', 'Chemical Engineer', 'Environmental Engineer', 'Bioinformatician',
            'Content Creator', 'Animator', 'HR Specialist', 'Data Analyst', 'Translator', 'Yoga Instructor', 'Fitness Trainer',
            'Interior Designer', 'Environmental Scientist', 'Event Planner', 'Financial Advisor', 'Travel Blogger', 'Photographer',
            'Nutritionist', 'Game Developer', 'Social Worker', 'Civil Engineer', 'Robotics Engineer', 'Ethical Hacker', 'Ethnographer',
            'Meteorologist', 'Political Analyst', 'Fashion Designer', 'Archaeologist', 'Art Therapist', 'Cryptocurrency Trader',
            'Blockchain Developer', 'Ethical Hacker', 'Marine Biologist', 'Zoologist', 'Personal Chef', 'Astronomer', 'Geologist',
            'Speech Therapist', 'Neuroscientist', 'Voice Actor', 'Film Director', 'Sound Designer', 'Ethical Hacker', 'AI Researcher',
            'Astrophysicist', 'Data Scientist', 'Climate Change Analyst', 'Wildlife Biologist', 'Forensic Scientist', 'Futurist',
            'Food Scientist', 'Neonatal Nurse', 'Cybersecurity Analyst', 'Chemical Engineer', 'Environmental Engineer', 'Bioinformatician',
            'Urban Planner', 'Fashion Stylist', 'Interior Decorator', 'User Experience Designer', 'Public Relations Specialist',
            'Media Buyer', 'Podcaster', 'Motivational Speaker', 'Cartoonist', 'Technical Writer', 'Historian', 'Sociologist',
            'Dentist', 'Chiropractor', 'Flight Attendant', 'Event Coordinator', 'Investment Banker', 'Clinical Psychologist',
            'Physical Therapist', 'Geophysicist', 'Horticulturist', 'Automotive Mechanic', 'Physical Education Teacher',
            'Speech Language Pathologist', 'Nurse Anesthetist', 'Animal Trainer', 'Brand Manager', 'Air Traffic Controller',
            'Loan Officer', 'Museum Curator', 'Park Ranger', 'Podiatrist', 'Chief Executive Officer', 'Chief Financial Officer',
            'Chief Operating Officer', 'Chief Technology Officer', 'Chief Marketing Officer', 'Chief Creative Officer',
            'Chief Human Resources Officer', 'Chief Data Officer', 'Chief Diversity Officer', 'Chief Sustainability Officer', 'Lainnya'
        ];
        return view('landing-page.service.celengan-syahid.donate-now')->with([
            'data' => $data,
            "title" => "Layanan",
            "cities" => $cities,
            "jobs" => $jobs
        ]);
    }

    public function donationStatus($link, $id)
    {
        $data = Donation::where('id',$id)->first();
        $campaign = Campaign::where('link', $link)->first();
        return view('landing-page.service.celengan-syahid.donation-status')->with([
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

    public function destroyAdminDonation($id)
    {
        Donation::deleteDonation($id);
        return redirect()->back();
    }

    public function dashboardCelenganSyahid()
    {
        $pythonExecutable = '/home/ldksyah1/virtualenv/ucupspython/3.9/bin/python';
        // $pythonExecutable = 'C:\Users\hp\AppData\Local\Programs\Python\Python311\python.exe';

        $scriptPath = '/home/ldksyah1/public_html/public/machine-learning/models/donation-class-machine.py';
        // $scriptPath = 'machine-learning/models/donation-class-machine.py';

        $command = [
            $pythonExecutable,
            $scriptPath
        ];

        $process = new Process($command, null, null, null, null);

        $process->start();

        $process->wait();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return view('admin-page.service.celengan-syahid.dashboard', ["title" => "Celengan Syahid"]);
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
        $data = Campaign::getDataDonationCampaignById($id);
        return view('admin-page.service.celengan-syahid.campaign.view')->with([
            'data' => $data,
            "title" => "Celengan Syahid",
            "province" => $province
        ]);
    }

     public function storeAdminCampaign(Request $request)
    {
        $gdriveService = new GoogleDrive($this->pathCampaignsGDrive);

        $target_biaya = LFC::replaceamount($request['target_biaya']);
        $provinsi = ucwords(strtolower($request["provinsi"]));
        $city = City::where('id', $request['kota'])->first();
        $kota = ucwords(strtolower($city->name));

        $fileNamePoster = time() . '_poster_' . $request->file('poster')->getClientOriginalName();
        $filePathPoster = $this->pathCampaignsGDrive . '/' . $fileNamePoster;
        $uploadResultPoster = $gdriveService->uploadImage($request->file('poster'), $fileNamePoster, $filePathPoster);

        $uploadResultLogoPic = [];
        if (!empty($request->logo_pj)) {
            $fileNameLogoPic = time() . '_logo-pic_' . $request->file('logo_pj')->getClientOriginalName();
            $filePathLogoPic = $this->pathCampaignsGDrive . '/' . $fileNameLogoPic;
            $uploadResultLogoPic = $gdriveService->uploadImage($request->file('logo_pj'), $fileNameLogoPic, $filePathLogoPic);
        }
        Campaign::createCampaign($request->all(), $provinsi, $kota, $target_biaya, $uploadResultPoster, $uploadResultLogoPic);
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
        $gdriveService = new GoogleDrive($this->pathCampaignsGDrive);
        $campaignModel = Campaign::find($id);
        $target_biaya = LFC::replaceamount($request['target_biaya']);
        $provinsi = ucwords(strtolower($request["provinsi"]));
        $city = City::where('id', $request['kota'])->first();
        if ($city != null) {
            $kota = ucwords(strtolower($city->name));
        } else {
            $kota = $request['kota'];
        }

        if ($request->file('poster')) {
            $fileNamePoster = time() . '_poster_' . $request->file('poster')->getClientOriginalName();
            $filePathPoster = $this->pathCampaignsGDrive . '/' . $fileNamePoster;
            $uploadResultPoster = $gdriveService->uploadImage($request->file('poster'), $fileNamePoster, $filePathPoster);
            if (!empty($uploadResultPoster)) {
                $oldGdriveID = $campaignModel->gdrive_id;
                if ($oldGdriveID) {
                    $gdriveService->deleteImage($oldGdriveID);
                }

                $campaignModel->update([
                    'poster' => $uploadResultPoster['fileName'],
                    'gdrive_id' => $uploadResultPoster['gdriveID'],
                ]);
            }
        }
        if ($request->file('logo_pj')) {
            $fileNameLogoPic = time() . '_logo-pic_' . $request->file('logo_pj')->getClientOriginalName();
            $filePathLogoPic = $this->pathCampaignsGDrive . '/' . $fileNameLogoPic;
            $uploadResultLogoPic = $gdriveService->uploadImage($request->file('logo_pj'), $fileNameLogoPic, $filePathLogoPic);
            if (!empty($uploadResultLogoPic)) {
                $oldGdriveID = $campaignModel->gdrive_id_1;
                if ($oldGdriveID) {
                    $gdriveService->deleteImage($oldGdriveID);
                }

                $campaignModel->update([
                    'logo_pj' => $uploadResultLogoPic['fileName'],
                    'gdrive_id_1' => $uploadResultLogoPic['gdriveID'],
                ]);
            }
        }
        Campaign::updateCampaign($id, $request->all(), $provinsi, $kota, $target_biaya);
        toast('Campaign has been updated !', 'success')->autoClose(1500)->width('400px');
        return redirect('/admin/service/celengansyahid/campaigns');
    }

    public function destroyAdminCampaign($id)
    {
        $gdriveService = new GoogleDrive($this->pathCampaignsGDrive);
        $campaignModel = Campaign::findOrFail($id);

        if (!empty($campaignModel->gdrive_id)) {
            $gdriveService->deleteImage($campaignModel->gdrive_id);
        }

        if (!empty($campaignModel->gdrive_id_1)) {
            $gdriveService->deleteImage($campaignModel->gdrive_id_1);
        }

        Campaign::deleteCampaign($id);
        return redirect()->back();
    }

    public function storeCity(request $request)
    {
        $dataProvince = Province::where('name', $request['id'])->first();
        $codeProvince = $dataProvince->code;
        $cities = City::where('province_code', $codeProvince)->pluck('name', 'id');
        return response()->json($cities);
    }
}

