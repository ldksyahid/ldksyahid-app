<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\News;
use App\Models\Article;
use App\Models\Event;
use App\Models\Schedule;
use App\Models\MsKTALDKSyahid;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Jumbotron;
use App\Models\Testimony;
use App\Models\Gallery;
use App\Models\ITSupport;
use App\Models\MessageContact;
use App\Models\Structure;
use App\Models\CallKestari;
use App\Models\MsShortlink;
use App\Models\ReqShortlink;
use App\Models\MsCatalogBook;
use App\Models\MsFinanceReport;
use AshAllenDesign\ShortURL\Models\ShortURL;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total data
        $userCount = User::count();
        $newsCount = News::count();
        $articleCount = Article::count();
        $eventCount = Event::count();
        $scheduleCount = Schedule::count();
        $shortLinkCount = ShortURL::count();
        $idCardCount = MsKTALDKSyahid::count();
        $campaignCount = Campaign::count();
        $donationCount = Donation::count();
        $jumbotronCount = Jumbotron::count();
        $testimonyCount = Testimony::count();
        $galleryCount = Gallery::count();
        $itSupportCount = ITSupport::count();
        $contactMessageCount = MessageContact::count();
        $structureCount = Structure::count();
        $callKestariCount = CallKestari::count();
        $shortlinkServiceCount = MsShortlink::count();
        $reqShortlinkCount = ReqShortlink::count();
        $catalogBookCount = MsCatalogBook::count();
        $financeReportCount = MsFinanceReport::count();

        // Ambil data waktu solat dari API Kemenag
        $cityId = 1301; // ID kota untuk Jakarta Pusat (ganti sesuai lokasi)
        $date = date('Y-m-d'); // Tanggal hari ini


        $response = Http::withOptions(['verify' => false,])->get('https://api.myquran.com/v2/sholat/jadwal/1301/2026-02-16');
        $prayerTimes = $response->json()['data']['jadwal'] ?? [];

        return view('admin-page.dashboard.index', [
            'title' => 'Dashboard',
            'userCount' => $userCount,
            'newsCount' => $newsCount,
            'articleCount' => $articleCount,
            'eventCount' => $eventCount,
            'scheduleCount' => $scheduleCount,
            'shortLinkCount' => $shortLinkCount,
            'prayerTimes' => $prayerTimes,
            'idCardCount' => $idCardCount,
            'campaignCount' => $campaignCount,
            'donationCount' => $donationCount,
            'jumbotronCount' => $jumbotronCount,
            'testimonyCount' => $testimonyCount,
            'galleryCount' => $galleryCount,
            'itSupportCount' => $itSupportCount,
            'contactMessageCount' => $contactMessageCount,
            'structureCount' => $structureCount,
            'callKestariCount' => $callKestariCount,
            'shortlinkServiceCount' => $shortlinkServiceCount,
            'reqShortlinkCount' => $reqShortlinkCount,
            'catalogBookCount' => $catalogBookCount,
            'financeReportCount' => $financeReportCount,
        ]);
    }
}
