<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Checks the Brevo free-plan daily sending quota (300 emails/day)
 * via the Brevo REST API before dispatching each email.
 *
 * Brevo silently accepts SMTP connections but drops emails once the
 * free-plan daily limit is exceeded — no exception is thrown, so jobs
 * would complete "successfully" while emails are lost. Checking the API
 * quota beforehand lets us detect and hold jobs until the quota resets.
 *
 * Requires BREVO_API_KEY in .env (SMTP & API → API Keys in Brevo dashboard).
 * If the key is not configured, the check is skipped entirely.
 */
class BrevoQuotaChecker
{
    const DAILY_LIMIT = 300;

    /** Cache key for today's quota check result. */
    const CACHE_KEY = 'brevo_quota_check';

    /**
     * Returns true if today's Brevo quota is exhausted.
     * The result is cached for 5 minutes so we don't hit the API on every job.
     * Returns false when BREVO_API_KEY is not set (quota check is disabled).
     */
    public static function isLimitExceeded(): bool
    {
        $apiKey = config('services.brevo.api_key');
        if (!$apiKey) {
            return false;
        }

        $cached = Cache::get(self::CACHE_KEY);
        if ($cached !== null) {
            return (bool) $cached;
        }

        return static::fetchAndCache($apiKey);
    }

    /**
     * Seconds until next midnight UTC — when Brevo free plan resets.
     */
    public static function secondsUntilReset(): int
    {
        $nextMidnightUtc = now('UTC')->startOfDay()->addDay();
        return (int) max(60, now('UTC')->diffInSeconds($nextMidnightUtc));
    }

    /**
     * Invalidate the cached quota result.
     * Called by the job framework when holding jobs so the next run re-checks.
     */
    public static function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    private static function fetchAndCache(string $apiKey): bool
    {
        try {
            $today    = now('UTC')->format('Y-m-d');
            $response = Http::timeout(10)
                ->withHeaders([
                    'api-key' => $apiKey,
                    'accept'  => 'application/json',
                ])
                ->get('https://api.brevo.com/v3/smtp/statistics/aggregatedReport', [
                    'startDate' => $today,
                    'endDate'   => $today,
                ]);

            if ($response->successful()) {
                $sentToday = (int) ($response->json('requests') ?? 0);
                $exceeded  = $sentToday >= self::DAILY_LIMIT;

                // Cache "not exceeded" for 5 min (re-check periodically as we approach limit).
                // Cache "exceeded" for 60 s only — the job also sets mail_daily_limit_exceeded
                // until midnight, so this short TTL is just a safety refresh window.
                Cache::put(self::CACHE_KEY, $exceeded, $exceeded ? 60 : 300);

                return $exceeded;
            }

            Log::error('[BrevoQuotaChecker] API returned status ' . $response->status());
        } catch (\Throwable $e) {
            Log::error('[BrevoQuotaChecker] API check failed: ' . $e->getMessage());
        }

        // On API error, assume not exceeded so we don't block sends indefinitely.
        Cache::put(self::CACHE_KEY, false, 60);
        return false;
    }
}
