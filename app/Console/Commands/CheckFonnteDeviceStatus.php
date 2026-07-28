<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Poll Fonnte's device profile endpoint and cache the WhatsApp connection
 * status (connect/disconnect) so /admin/job-queue-log can surface it. There
 * is no reconnect API — a disconnected device always needs a manual
 * re-scan in the Fonnte dashboard, so this is purely informational.
 */
class CheckFonnteDeviceStatus extends Command
{
    protected $signature = 'fonnte:check-device-status';

    protected $description = 'Poll the Fonnte device status API and cache connect/disconnect for the Job Queue Log dashboard.';

    public function handle(): int
    {
        $token = config('services.fonnte.token');

        if (blank($token)) {
            Log::warning('[CheckFonnteDeviceStatus] Skipped: FONNTE_TOKEN is not configured.');
            return self::SUCCESS;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post(config('services.fonnte.base_url') . '/device');

            if (!$response->successful()) {
                Log::warning('[CheckFonnteDeviceStatus] API returned HTTP ' . $response->status(), [
                    'response' => $response->json(),
                ]);
                return self::SUCCESS;
            }

            $status = $response->json('device_status');

            if (!in_array($status, ['connect', 'disconnect'], true)) {
                Log::warning('[CheckFonnteDeviceStatus] Unexpected device_status value', [
                    'response' => $response->json(),
                ]);
                return self::SUCCESS;
            }

            // TTL (25min) intentionally longer than the check interval (10min,
            // see Kernel.php) — a single failed/timed-out check keeps showing
            // the last known status instead of immediately going "unknown".
            Cache::put('fonnte_device_status', $status, now()->addMinutes(25));

            $this->info("Fonnte device status: {$status}");
        } catch (\Throwable $e) {
            Log::warning('[CheckFonnteDeviceStatus] Request failed: ' . $e->getMessage());
        }

        return self::SUCCESS;
    }
}
