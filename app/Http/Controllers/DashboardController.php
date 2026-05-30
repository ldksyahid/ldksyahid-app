<?php

namespace App\Http\Controllers;

use App\Constants\SettingKey\Key1;
use App\Models\MsSetting;
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
use App\Models\TrSubscription;
use AshAllenDesign\ShortURL\Models\ShortURL;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\VisitorAnalyticsController;

class DashboardController extends Controller
{
    public function index()
    {
        // Count totals for each entity
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
        $subscriberCount = TrSubscription::where('flagActive', true)->count();

        // Deadline alerts: show when within 30 days of deadline or overdue
        $deadlineAlerts = MsSetting::where('key1', Key1::DEADLINE)
            ->get()
            ->map(function ($row) {
                $deadline     = \Carbon\Carbon::parse($row->value1);
                $daysRemaining = (int) now()->diffInDays($deadline, false);
                return [
                    'label'          => $row->key2,
                    'date_formatted' => $deadline->translatedFormat('d F Y'),
                    'cost'           => $row->value2 ? 'Rp ' . number_format((int) $row->value2, 0, ',', '.') : null,
                    'days_remaining' => $daysRemaining,
                    'is_overdue'     => $daysRemaining < 0,
                ];
            })
            ->filter(fn($item) => $item['days_remaining'] <= 30)
            ->values();

        // Visitor analytics summary
        $visitorSummary = VisitorAnalyticsController::getSummary();

        // Fetch prayer times from Kemenag API
        $cityId = 1301; // City ID for Central Jakarta (change as needed)
        $date = date('Y-m-d'); // Today's date


        $response = Http::get("https://api.myquran.com/v2/sholat/jadwal/$cityId/$date");
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
            'subscriberCount' => $subscriberCount,
            'visitorSummary'   => $visitorSummary,
            'deadlineAlerts'   => $deadlineAlerts,
        ]);
    }
}
