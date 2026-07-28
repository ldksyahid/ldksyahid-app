<?php

namespace App\Http\Controllers;

use App\Models\TrJobQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobQueueLogController extends Controller
{
    public function index()
    {
        return view('admin-page.job-queue-log.index')
            ->with('title', 'Job Queue Log');
    }

    public function data(Request $request)
    {
        $now               = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $dailyLimitActive  = $this->isGmailDailyLimitActive();
        $status            = $request->get('status', 'all');

        // Failed jobs come from a different table — handle separately
        if ($status === 'failed') {
            return $this->failedData($request, $now, $dailyLimitActive);
        }

        $query = TrJobQueue::query();

        switch ($status) {
            case 'pending':
                $query->whereNull('reservedDate')->where('availableDate', '<=', $now);
                break;
            case 'processing':
                $query->whereNotNull('reservedDate');
                break;
            case 'delayed':
                $query->whereNull('reservedDate')->where('availableDate', '>', $now);
                if ($dailyLimitActive) {
                    $query->where('attempts', 0);
                }
                break;
            case 'daily_limit':
                // Email-only concept (Brevo/Gmail daily cap) — scope to
                // queue='email' so a rate-limited WhatsApp job in the same
                // delayed-with-attempts shape never gets swept in here.
                $query->where('queue', 'email')
                      ->whereNull('reservedDate')->where('availableDate', '>', $now)->where('attempts', '>', 0);
                break;
            case 'stuck':
                $query->where('attempts', '>=', 8);
                if ($dailyLimitActive) {
                    // Only hide EMAIL jobs here that are already shown under
                    // the 'daily_limit' filter instead (avoids listing them
                    // twice). A stuck WhatsApp job must always show under
                    // "Stuck" regardless of Gmail's limit state — WA has no
                    // daily_limit bucket to overlap with in the first place.
                    $query->where(function ($q) use ($now) {
                        $q->where('queue', '!=', 'email')
                          ->orWhere('availableDate', '<=', $now)
                          ->orWhereNotNull('reservedDate');
                    });
                }
                break;
        }

        if ($request->filled('queue') && $request->get('queue') !== 'all') {
            $query->where('queue', $request->get('queue'));
        }

        if ($request->filled('search')) {
            $query->where('payload', 'like', '%' . $request->get('search') . '%');
        }

        $jobs = $query->orderByDesc('ID')->paginate(15);

        $jobs->getCollection()->transform(function ($job) use ($now, $dailyLimitActive) {
            $payload            = json_decode($job->payload, true) ?? [];
            $job->job_type      = $this->parseJobType($payload);
            $job->job_full      = $payload['displayName'] ?? 'Unknown';
            $job->job_uuid      = $payload['uuid'] ?? '-';
            $job->job_status    = $this->computeStatus($job, $now, $dailyLimitActive);
            $job->mail_info     = $this->extractMailInfo($payload);
            $job->payload_clean = $this->cleanPayload($payload);
            unset($job->payload);
            return $job;
        });

        return response()->json([
            'jobs'                  => $jobs,
            'stats'                 => $this->getStats($now, $dailyLimitActive),
            'queues'                => TrJobQueue::distinct()->pluck('queue'),
            'server_time'           => $now,
            'gmail_daily_limit'     => $dailyLimitActive,
            'is_failed_view'        => false,
            'fonnte_device_status'      => $this->fonnteDeviceStatus(),
            'whatsapp_rate_per_minute'  => (int) env('WHATSAPP_RATE_PER_MINUTE', 8),
        ]);
    }

    private function failedData(Request $request, string $now, bool $dailyLimitActive)
    {
        $query = DB::table('failed_jobs');

        if ($request->filled('queue') && $request->get('queue') !== 'all') {
            $query->where('queue', $request->get('queue'));
        }

        if ($request->filled('search')) {
            $query->where('payload', 'like', '%' . $request->get('search') . '%');
        }

        $jobs = $query->orderByDesc('id')->paginate(15);

        $jobs->getCollection()->transform(function ($job) {
            $payload            = json_decode($job->payload, true) ?? [];
            $job->ID            = $job->id;
            $job->job_type      = $this->parseJobType($payload);
            $job->job_full      = $payload['displayName'] ?? 'Unknown';
            $job->job_uuid      = $payload['uuid'] ?? $job->uuid;
            $job->job_status    = 'failed';
            $job->mail_info     = $this->extractMailInfo($payload);
            $job->payload_clean = $this->cleanPayload($payload);
            $job->attempts      = '-';
            $job->availableDate = null;
            $job->reservedDate  = null;
            $job->createdDate   = $job->failed_at;
            $job->exception_short = Str::limit($job->exception, 300);
            unset($job->exception, $job->payload);
            return $job;
        });

        return response()->json([
            'jobs'                  => $jobs,
            'stats'                 => $this->getStats($now, $dailyLimitActive),
            'queues'                => TrJobQueue::distinct()->pluck('queue'),
            'server_time'           => $now,
            'gmail_daily_limit'     => $dailyLimitActive,
            'is_failed_view'        => true,
            'fonnte_device_status'      => $this->fonnteDeviceStatus(),
            'whatsapp_rate_per_minute'  => (int) env('WHATSAPP_RATE_PER_MINUTE', 8),
        ]);
    }

    public function destroy($id)
    {
        $job = TrJobQueue::find($id);
        if (!$job) {
            return response()->json(['success' => false, 'message' => 'Job #' . $id . ' was not found. It may have already been processed or deleted.'], 404);
        }
        $job->delete();
        return response()->json(['success' => true]);
    }

    // ── Failed Job Operations ────────────────────────────────────────────

    public function retryFailed($id)
    {
        $job = DB::table('failed_jobs')->where('id', $id)->first();
        if (!$job) {
            return response()->json(['success' => false, 'message' => 'Failed job #' . $id . ' not found.'], 404);
        }

        Artisan::call('queue:retry', ['id' => [$job->uuid]]);

        return response()->json(['success' => true]);
    }

    public function retryAllFailed()
    {
        $count = DB::table('failed_jobs')->count();
        if ($count === 0) {
            return response()->json(['success' => false, 'message' => 'No failed jobs to retry.'], 404);
        }

        Artisan::call('queue:retry', ['id' => ['all']]);

        return response()->json(['success' => true, 'retried' => $count]);
    }

    public function destroyFailed($id)
    {
        $job = DB::table('failed_jobs')->where('id', $id)->first();
        if (!$job) {
            return response()->json(['success' => false, 'message' => 'Failed job #' . $id . ' not found.'], 404);
        }

        DB::table('failed_jobs')->where('id', $id)->delete();

        return response()->json(['success' => true]);
    }

    public function destroyAllFailed()
    {
        $count = DB::table('failed_jobs')->count();
        DB::table('failed_jobs')->truncate();

        return response()->json(['success' => true, 'deleted' => $count]);
    }

    // ── Stuck Job Operations ─────────────────────────────────────────────

    public function destroyStuck()
    {
        $query = TrJobQueue::where('attempts', '>=', 8);

        // When daily limit is active, don't delete jobs that are just waiting for reset
        if ($this->isGmailDailyLimitActive()) {
            $now = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
            $query->where(function ($q) use ($now) {
                $q->where('availableDate', '<=', $now)
                  ->orWhereNotNull('reservedDate');
            });
        }

        $count = $query->delete();
        return response()->json(['success' => true, 'deleted' => $count]);
    }

    private function getStats(string $now, bool $dailyLimitActive): array
    {
        $delayedBase = TrJobQueue::whereNull('reservedDate')->where('availableDate', '>', $now);
        $stuckBase   = TrJobQueue::where('attempts', '>=', 8);

        $dailyLimitCount = 0;
        if ($dailyLimitActive) {
            // Email-only (Brevo/Gmail daily cap) — a rate-limited WhatsApp
            // job (attempts>0, availableDate in the future) is completely
            // normal and unrelated, so it must not be attributed here.
            $dailyLimitCount = (clone $delayedBase)->where('queue', 'email')->where('attempts', '>', 0)->count();
            // Everything else still delayed (any non-email job regardless of
            // attempts, plus email jobs with attempts=0) stays "Delayed".
            $delayedCount    = $delayedBase->count() - $dailyLimitCount;
            // Same email-only exclusion as the 'stuck' filter case in data()
            // — a stuck WhatsApp job must always be counted here.
            $stuckCount      = (clone $stuckBase)->where(function ($q) use ($now) {
                $q->where('queue', '!=', 'email')
                  ->orWhere('availableDate', '<=', $now)->orWhereNotNull('reservedDate');
            })->count();
        } else {
            $delayedCount = $delayedBase->count();
            $stuckCount   = $stuckBase->count();
        }

        return [
            'total'             => TrJobQueue::count(),
            'pending'           => TrJobQueue::whereNull('reservedDate')->where('availableDate', '<=', $now)->count(),
            'processing'        => TrJobQueue::whereNotNull('reservedDate')->count(),
            'delayed'           => $delayedCount,
            'stuck'             => $stuckCount,
            'daily_limit'       => $dailyLimitCount,
            'failed'            => DB::table('failed_jobs')->count(),
            // Queue-scoped counts for the two separate "Estimated Completion"
            // cards — the generic 'pending' above mixes every queue together,
            // which would wrongly blend the email (Brevo daily-limit) and
            // WhatsApp (rate-limit-only, no daily cap) bottlenecks into one
            // misleading number if used for ETA math.
            //
            // Deliberately just "not yet reserved", with no availableDate or
            // $dailyLimitActive condition — $dailyLimitActive is a transient
            // cache flag that only gets refreshed while the worker is
            // actively touching these jobs. A held-for-reset job whose
            // availableDate is far in the future won't be touched again
            // until then, so the flag can read false in between even though
            // the backlog is very much still there — undercounting it to 0
            // ("Queue is clear") if this were conditioned on that flag.
            'email_pending'     => TrJobQueue::where('queue', 'email')->whereNull('reservedDate')->count(),
            'whatsapp_pending'  => TrJobQueue::where('queue', 'whatsapp')->whereNull('reservedDate')->count(),
        ];
    }

    private function parseJobType(array $payload): string
    {
        $name = $payload['displayName'] ?? '';
        if ($name) {
            $parts = explode('\\', $name);
            return end($parts);
        }
        return 'Unknown';
    }

    private function computeStatus($job, string $now, bool $dailyLimitActive): string
    {
        // Email-only concept (Brevo/Gmail daily cap) — without the queue
        // check, a WhatsApp job that got rate-limiter-released (attempts>0,
        // availableDate in the future — completely normal for it) would be
        // mislabeled "Daily Limit" whenever the Gmail limit also happens to
        // be active, even though the two have nothing to do with each other.
        if ($dailyLimitActive && $job->queue === 'email' && $job->availableDate > $now && is_null($job->reservedDate) && $job->attempts > 0) {
            return 'daily_limit';
        }
        if ($job->attempts >= 8) return 'stuck';
        if (!is_null($job->reservedDate)) return 'processing';
        if ($job->availableDate > $now) return 'delayed';
        return 'pending';
    }

    private function isGmailDailyLimitActive(): bool
    {
        // Cache key generalized from Gmail to any mail relay (Brevo).
        return Cache::has('mail_daily_limit_exceeded');
    }

    /**
     * WhatsApp (Fonnte) device connect/disconnect status, populated by the
     * fonnte:check-device-status scheduled command. Null means the cache
     * has never been populated (e.g. right after deploy) — the frontend
     * renders that as "Unknown", not an error.
     */
    private function fonnteDeviceStatus(): ?string
    {
        return Cache::get('fonnte_device_status');
    }

    private function extractMailInfo(array $payload): array
    {
        $info    = [];
        $command = $payload['data']['command'] ?? '';
        if (!$command) return $info;

        // Extract email addresses from PHP serialized string
        preg_match_all('/[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}/', $command, $m);
        $emails = array_values(array_unique(
            array_filter($m[0] ?? [], fn($e) => filter_var($e, FILTER_VALIDATE_EMAIL))
        ));
        if (!empty($emails)) {
            $info['to'] = count($emails) === 1 ? $emails[0] : count($emails) . ' recipients';
        }

        // Extract subject from serialized string
        if (preg_match('/s:\d+:"subject";s:\d+:"([^"]{1,255})"/', $command, $match)) {
            $info['subject'] = $match[1];
        }

        return $info;
    }

    private function cleanPayload(array $payload): string
    {
        $clean = $payload;
        if (isset($clean['data']['command'])) {
            $clean['data']['command'] = '[PHP Serialized Object — omitted for readability]';
        }
        return json_encode($clean, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
