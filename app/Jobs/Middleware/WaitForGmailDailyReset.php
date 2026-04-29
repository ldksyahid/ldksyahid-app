<?php

namespace App\Jobs\Middleware;

use Illuminate\Support\Facades\Cache;

/**
 * Middleware untuk job email.
 *
 * Jika Gmail daily sending limit sedang aktif (ditandai via cache),
 * job akan di-release kembali ke queue sampai limit reset —
 * sehingga job tidak perlu dieksekusi ulang dari awal, hanya ditunda.
 */
class WaitForGmailDailyReset
{
    public function handle(object $job, callable $next): void
    {
        $resetAt = Cache::get('gmail_daily_limit_exceeded');

        if ($resetAt) {
            // Hitung sisa waktu sampai limit reset, minimum 60 detik
            $delay = max(60, $resetAt - now()->timestamp);
            $job->release($delay);
            return;
        }

        $next($job);
    }
}
