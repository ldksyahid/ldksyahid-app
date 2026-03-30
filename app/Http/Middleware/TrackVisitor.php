<?php

namespace App\Http\Middleware;

use App\Helpers\DatacenterDetector;
use App\Helpers\GeoIpHelper;
use App\Models\TrVisitorLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class TrackVisitor
{
    /**
     * Routes/prefixes to exclude from tracking.
     */
    private const EXCLUDED_PREFIXES = [
        'admin',
        'api',
        '_debugbar',
        'telescope',
        'horizon',
    ];

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only track GET requests on public routes
        if ($request->method() !== 'GET' || $this->isExcluded($request)) {
            return $response;
        }

        try {
            $this->track($request);
        } catch (\Throwable $e) {
            // Never break the page due to tracking errors
            \Log::warning('TrackVisitor error: ' . $e->getMessage());
        }

        return $response;
    }

    private function isExcluded(Request $request): bool
    {
        $path = ltrim($request->path(), '/');

        foreach (self::EXCLUDED_PREFIXES as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix . '/')) {
                return true;
            }
        }

        return false;
    }

    private function track(Request $request): void
    {
        // TrustProxies is already in global stack — $request->ip() is correct
        $ip     = $request->ip();
        $date   = now()->toDateString();
        $ipHash = hash('sha256', $ip . $date . config('app.key'));

        // Check if this IP has already been counted today
        $alreadyUnique = DB::table('tr_visitor_daily_unique')
            ->where('ipHash', $ipHash)
            ->where('visitDate', $date)
            ->exists();

        $isUniqueDaily = 0;

        if (!$alreadyUnique) {
            // First visit today — insert and mark as unique
            DB::table('tr_visitor_daily_unique')->insert([
                'ipHash'      => $ipHash,
                'visitDate'   => $date,
                'visitCount'  => 1,
                'firstPath'   => '/' . ltrim($request->path(), '/'),
                'createdDate' => now(),
                'updatedDate' => now(),
            ]);
            $isUniqueDaily = 1;
        } else {
            // Returning visitor today — just increment
            DB::table('tr_visitor_daily_unique')
                ->where('ipHash', $ipHash)
                ->where('visitDate', $date)
                ->increment('visitCount', 1, ['updatedDate' => now()]);
        }

        // Parse user agent
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        $isBot   = $agent->isRobot() ? 1 : 0;
        $browser = $agent->browser() ?: null;
        $os      = $agent->platform() ?: null;

        // Secondary bot detection: flag datacenter IPs that passed user-agent check.
        // Bots disguised as browsers (headless, scrapers) are caught here via ASN lookup.
        if (!$isBot && DatacenterDetector::isDatacenter($ip)) {
            $isBot   = 1;
            $browser = null;
            $os      = null;
        }

        if ($isBot) {
            $deviceType = 'bot';
        } elseif ($agent->isTablet()) {
            $deviceType = 'tablet';
        } elseif ($agent->isMobile()) {
            $deviceType = 'mobile';
        } elseif ($agent->isDesktop()) {
            $deviceType = 'desktop';
        } else {
            $deviceType = 'unknown';
        }

        $path = '/' . ltrim($request->path(), '/');

        // Geo lookup
        $geo = GeoIpHelper::lookup($ip);

        // Check if this IP has already visited THIS specific page today
        // (must happen BEFORE inserting new log so we don't count the current visit)
        $isUniqueOnPage = DB::table('tr_visitor_log')
            ->where('ipHash', $ipHash)
            ->where('path', $path)
            ->whereDate('visitedAt', $date)
            ->doesntExist() ? 1 : 0;

        // Insert raw visitor log
        TrVisitorLog::create([
            'ipAddress'     => $ip,
            'ipHash'        => $ipHash,
            'path'          => $path,
            'queryString'   => $request->getQueryString() ?: null,
            'referer'       => $request->header('referer') ?: null,
            'userAgent'     => $request->userAgent(),
            'deviceType'    => $deviceType,
            'browser'       => $browser,
            'os'            => $os,
            'isUniqueDaily' => $isUniqueDaily,
            'isBot'         => $isBot,
            'country'       => $geo['country'],
            'countryCode'   => $geo['countryCode'],
            'visitedAt'     => now(),
        ]);

        // Upsert page stat — uniqueVisitors counts distinct IPs per page per day
        DB::statement("
            INSERT INTO tr_visitor_page_stat
                (statDate, path, totalHits, uniqueVisitors, mobileHits, desktopHits, tabletHits, botHits, createdDate, updatedDate)
            VALUES
                (?, ?, 1, ?, ?, ?, ?, ?, NOW(), NOW())
            ON DUPLICATE KEY UPDATE
                totalHits      = totalHits + 1,
                uniqueVisitors = uniqueVisitors + VALUES(uniqueVisitors),
                mobileHits     = mobileHits  + VALUES(mobileHits),
                desktopHits    = desktopHits + VALUES(desktopHits),
                tabletHits     = tabletHits  + VALUES(tabletHits),
                botHits        = botHits     + VALUES(botHits),
                updatedDate    = NOW()
        ", [
            $date,
            $path,
            $isUniqueOnPage,
            $deviceType === 'mobile'  ? 1 : 0,
            $deviceType === 'desktop' ? 1 : 0,
            $deviceType === 'tablet'  ? 1 : 0,
            $isBot,
        ]);
    }
}
