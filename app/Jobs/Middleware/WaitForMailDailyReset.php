<?php

namespace App\Jobs\Middleware;

use Illuminate\Support\Facades\Cache;

/**
 * Job middleware for outgoing email.
 *
 * When the mail relay's daily sending limit is active (flagged in cache),
 * the job is released back onto the queue until the limit resets — so the
 * job is only postponed, never re-executed from scratch.
 */
class WaitForMailDailyReset
{
    public function handle(object $job, callable $next): void
    {
        $resetAt = Cache::get('mail_daily_limit_exceeded');

        if ($resetAt) {
            // Time remaining until the limit resets, minimum 60 seconds.
            $delay = max(60, $resetAt - now()->timestamp);
            $job->release($delay);
            return;
        }

        $next($job);
    }
}
