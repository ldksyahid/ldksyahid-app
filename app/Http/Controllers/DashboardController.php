<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\News;
use App\Models\Article;
use App\Models\Event;
use AshAllenDesign\ShortURL\Models\ShortURL;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

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

        // Hitung jumlah pengunjung unik
        if (!Session::has('visitor_counted')) {
            Session::put('visitor_counted', true);
            Session::increment('visitor_count');
        }
        $visitorCount = Session::get('visitor_count', 0);

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
            'visitorCount' => $visitorCount,
            'prayerTimes' => $prayerTimes,
        ]);
    }
}
