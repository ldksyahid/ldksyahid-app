<?php

namespace App\Console\Commands;

use App\Services\Kirimdev;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Poll Kirimdev's /accounts endpoint and cache this app's WhatsApp phone
 * number status so /admin/job-queue-log can surface it. This reflects
 * Meta's own phone-number health (connected/disconnected/degraded/
 * onboarding) — there is no reconnect API for any of these; a
 * disconnected/degraded number needs attention in the Kirimdev dashboard
 * (or Meta Business Manager), so this is purely informational.
 */
class CheckKirimdevAccountStatus extends Command
{
    protected $signature = 'kirimdev:check-account-status';

    protected $description = 'Poll the Kirimdev accounts API and cache this app\'s WhatsApp phone number status for the Job Queue Log dashboard.';

    public function handle(): int
    {
        if (blank(config('services.kirimdev.api_key')) || blank(config('services.kirimdev.phone_number_id'))) {
            Log::warning('[CheckKirimdevAccountStatus] Skipped: Kirimdev is not configured yet.');
            return self::SUCCESS;
        }

        try {
            $account = Kirimdev::getAccountStatus();

            if ($account === null) {
                Log::warning('[CheckKirimdevAccountStatus] phone_number_id not found in Kirimdev accounts list.');
                return self::SUCCESS;
            }

            $status = $account['status'] ?? null;

            if (!in_array($status, ['connected', 'disconnected', 'degraded', 'onboarding'], true)) {
                Log::warning('[CheckKirimdevAccountStatus] Unexpected status value', ['account' => $account]);
                return self::SUCCESS;
            }

            // TTL (25min) intentionally longer than the check interval (10min,
            // see Kernel.php) — a single failed/timed-out check keeps showing
            // the last known status instead of immediately going "unknown".
            Cache::put('kirimdev_account_status', $status, now()->addMinutes(25));

            $this->info("Kirimdev account status: {$status}");
        } catch (\Throwable $e) {
            Log::warning('[CheckKirimdevAccountStatus] Request failed: ' . $e->getMessage());
        }

        return self::SUCCESS;
    }
}
