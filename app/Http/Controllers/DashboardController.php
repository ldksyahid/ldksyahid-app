<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\News;
use App\Models\Article;
use App\Models\Event;
use App\Models\MsKTALDKSyahid;
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
        $shortLinkCount = ShortURL::count();
        $idCardCount = MsKTALDKSyahid::count();

        // Ambil data waktu solat dari API Kemenag
        $cityId = 1301; // ID kota untuk Jakarta Pusat (ganti sesuai lokasi)
        $date = date('Y-m-d'); // Tanggal hari ini

        $response = Http::get("https://api.myquran.com/v2/sholat/jadwal/$cityId/$date");
        $prayerTimes = $response->json()['data']['jadwal'] ?? [];

        return view('admin-page.dashboard.index', [
            'title' => 'Dashboard',
            'userCount' => $userCount,
            'newsCount' => $newsCount,
            'articleCount' => $articleCount,
            'eventCount' => $eventCount,
            'shortLinkCount' => $shortLinkCount,
            'prayerTimes' => $prayerTimes,
            'idCardCount' => $idCardCount,
        ]);
    }
}
