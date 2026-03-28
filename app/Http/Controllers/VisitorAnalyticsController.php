<?php

namespace App\Http\Controllers;

use App\Models\TrVisitorLog;
use App\Models\TrVisitorPageStat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitorAnalyticsController extends Controller
{
    /**
     * JSON stats endpoint for AJAX charts.
     */
    public function apiStats(Request $request)
    {
        [$startDate, $endDate] = $this->parseDateRange($request);

        $summary      = $this->getSummary();
        $chart        = $this->getChartData($startDate, $endDate);
        $topPages     = $this->getTopPages($startDate, $endDate);
        $devices      = $this->getDeviceBreakdown($startDate, $endDate);
        $countries    = $this->getCountryStats($startDate, $endDate);
        $botCountries = $this->getBotCountryStats($startDate, $endDate);

        return response()->json([
            'summary'      => $summary,
            'chart'        => $chart,
            'topPages'     => $topPages,
            'devices'      => $devices,
            'countries'    => $countries,
            'botCountries' => $botCountries,
        ]);
    }

    /**
     * Parse and validate start_date / end_date from request.
     */
    private function parseDateRange(Request $request): array
    {
        $defaultStart = now()->subDays(29)->toDateString();
        $defaultEnd   = today()->toDateString();

        try {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date', $defaultStart))->toDateString();
            $endDate   = Carbon::createFromFormat('Y-m-d', $request->input('end_date',   $defaultEnd))->toDateString();
        } catch (\Exception $e) {
            return [$defaultStart, $defaultEnd];
        }

        if ($startDate > $endDate) {
            [$startDate, $endDate] = [$endDate, $startDate];
        }

        return [$startDate, $endDate];
    }

    /**
     * Summary card data (today / this month / this year / all-time / active now).
     * Always shows absolute totals — not filtered by date range.
     */
    public static function getSummary(): array
    {
        $today = TrVisitorLog::whereDate('visitedAt', today())
            ->where('isUniqueDaily', 1)
            ->where('isBot', 0)
            ->count();

        $month = TrVisitorLog::whereYear('visitedAt', now()->year)
            ->whereMonth('visitedAt', now()->month)
            ->where('isUniqueDaily', 1)
            ->where('isBot', 0)
            ->count();

        $year = TrVisitorLog::whereYear('visitedAt', now()->year)
            ->where('isUniqueDaily', 1)
            ->where('isBot', 0)
            ->count();

        $allTime = TrVisitorLog::where('isBot', 0)
            ->where('isUniqueDaily', 1)
            ->count();

        $activeNow = TrVisitorLog::where('visitedAt', '>=', now()->subMinutes(30))
            ->where('isBot', 0)
            ->distinct('ipHash')
            ->count('ipHash');

        $botToday = TrVisitorLog::whereDate('visitedAt', today())
            ->where('isBot', 1)
            ->count();

        $botMonth = TrVisitorLog::whereYear('visitedAt', now()->year)
            ->whereMonth('visitedAt', now()->month)
            ->where('isBot', 1)
            ->count();

        $botYear = TrVisitorLog::whereYear('visitedAt', now()->year)
            ->where('isBot', 1)
            ->count();

        $botAllTime = TrVisitorLog::where('isBot', 1)->count();

        return compact('today', 'month', 'year', 'allTime', 'activeNow', 'botToday', 'botMonth', 'botYear', 'botAllTime');
    }

    /**
     * Line chart: unique visitors + bot hits per day within the date range.
     */
    private function getChartData(string $startDate, string $endDate): array
    {
        $rows = TrVisitorLog::selectRaw(
                'DATE(visitedAt) as date,
                 SUM(CASE WHEN isBot = 0 AND isUniqueDaily = 1 THEN 1 ELSE 0 END) as humanCount,
                 SUM(CASE WHEN isBot = 1 THEN 1 ELSE 0 END) as botCount'
            )
            ->where('visitedAt', '>=', $startDate . ' 00:00:00')
            ->where('visitedAt', '<=', $endDate . ' 23:59:59')
            ->groupByRaw('DATE(visitedAt)')
            ->orderByRaw('DATE(visitedAt)')
            ->get()
            ->keyBy('date');

        $labels   = [];
        $data     = [];
        $botData  = [];
        $current  = Carbon::parse($startDate);
        $end      = Carbon::parse($endDate);

        while ($current->lte($end)) {
            $date      = $current->toDateString();
            $labels[]  = $date;
            $data[]    = $rows->has($date) ? (int) $rows[$date]->humanCount : 0;
            $botData[] = $rows->has($date) ? (int) $rows[$date]->botCount   : 0;
            $current->addDay();
        }

        return compact('labels', 'data', 'botData');
    }

    /**
     * Top pages by total hits in the date range (used by apiStats for dashboard preview).
     */
    private function getTopPages(string $startDate, string $endDate): array
    {
        return TrVisitorPageStat::select('path', DB::raw('SUM(totalHits) as hits'), DB::raw('SUM(uniqueVisitors) as uniques'))
            ->whereBetween('statDate', [$startDate, $endDate])
            ->groupBy('path')
            ->orderByDesc('hits')
            ->limit(8)
            ->get()
            ->toArray();
    }

    /**
     * Paginated + searchable top pages (AJAX for analytics page table).
     */
    public function topPagesAjax(Request $request)
    {
        [$startDate, $endDate] = $this->parseDateRange($request);
        $search    = trim($request->input('search', ''));
        $sortBy    = in_array($request->input('sort_by'), ['hits', 'uniques']) ? $request->input('sort_by') : 'hits';
        $sortOrder = $request->input('sort_order', 'desc') === 'asc' ? 'asc' : 'desc';

        $query = TrVisitorPageStat::select(
                'path',
                DB::raw('SUM(totalHits) as hits'),
                DB::raw('SUM(uniqueVisitors) as uniques')
            )
            ->whereBetween('statDate', [$startDate, $endDate])
            ->groupBy('path');

        if ($search !== '') {
            $query->where('path', 'like', '%' . $search . '%');
        }

        $query->orderByDesc($sortBy === 'hits' ? DB::raw('SUM(totalHits)') : DB::raw('SUM(uniqueVisitors)'));
        if ($sortOrder === 'asc') {
            $query->reorder($sortBy === 'hits' ? DB::raw('SUM(totalHits)') : DB::raw('SUM(uniqueVisitors)'), 'asc');
        }

        $items = $query->paginate(15)->withQueryString();

        $html = view('admin-page.analytics.visitors.components._top-pages-rows', [
            'items' => $items,
        ])->render();

        return response()->json([
            'html'       => $html,
            'pagination' => (string) $items->links('pagination::bootstrap-4'),
            'total'      => $items->total(),
            'from'       => $items->firstItem() ?? 0,
            'to'         => $items->lastItem() ?? 0,
        ]);
    }

    /**
     * Top countries by distinct visitors within the date range.
     */
    private function getCountryStats(string $startDate, string $endDate): array
    {
        return TrVisitorLog::select(
                'countryCode',
                'country',
                DB::raw('COUNT(DISTINCT ipHash) as visitors'),
                DB::raw('COUNT(*) as hits')
            )
            ->whereNotNull('countryCode')
            ->where('isBot', 0)
            ->where('visitedAt', '>=', $startDate . ' 00:00:00')
            ->where('visitedAt', '<=', $endDate . ' 23:59:59')
            ->groupBy('countryCode', 'country')
            ->orderByDesc('visitors')
            ->limit(15)
            ->get()
            ->map(fn ($r) => [
                'countryCode' => $r->countryCode,
                'country'     => $r->country,
                'visitors'    => (int) $r->visitors,
                'hits'        => (int) $r->hits,
            ])
            ->toArray();
    }

    /**
     * Top countries by bot traffic within the date range.
     */
    private function getBotCountryStats(string $startDate, string $endDate): array
    {
        return TrVisitorLog::select(
                'countryCode',
                'country',
                DB::raw('COUNT(DISTINCT ipHash) as bots'),
                DB::raw('COUNT(*) as hits')
            )
            ->whereNotNull('countryCode')
            ->where('isBot', 1)
            ->where('visitedAt', '>=', $startDate . ' 00:00:00')
            ->where('visitedAt', '<=', $endDate . ' 23:59:59')
            ->groupBy('countryCode', 'country')
            ->orderByDesc('hits')
            ->limit(10)
            ->get()
            ->map(fn ($r) => [
                'countryCode' => $r->countryCode,
                'country'     => $r->country,
                'bots'        => (int) $r->bots,
                'hits'        => (int) $r->hits,
            ])
            ->toArray();
    }

    /**
     * Device breakdown totals within the date range.
     */
    private function getDeviceBreakdown(string $startDate, string $endDate): array
    {
        $row = TrVisitorPageStat::select(
            DB::raw('SUM(mobileHits) as mobile'),
            DB::raw('SUM(desktopHits) as desktop'),
            DB::raw('SUM(tabletHits) as tablet'),
            DB::raw('SUM(botHits) as bot')
        )
            ->whereBetween('statDate', [$startDate, $endDate])
            ->first();

        return [
            'mobile'  => (int) ($row->mobile  ?? 0),
            'desktop' => (int) ($row->desktop ?? 0),
            'tablet'  => (int) ($row->tablet  ?? 0),
            'bot'     => (int) ($row->bot     ?? 0),
        ];
    }
}
