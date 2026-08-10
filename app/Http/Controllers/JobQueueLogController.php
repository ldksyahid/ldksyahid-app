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
        $now       = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $threshold = $this->dailyLimitThreshold($now);
        $status    = $request->get('status', 'all');

        // Failed jobs come from a different table — handle separately
        if ($status === 'failed') {
            return $this->failedData($request, $now);
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
                // Exclude what 'daily_limit' below already shows (avoid double-listing).
                $query->where(function ($q) use ($threshold) {
                    $q->where('queue', '!=', 'email')
                      ->orWhere('attempts', 0)
                      ->orWhere('availableDate', '<=', $threshold);
                });
                break;
            case 'daily_limit':
                // Email-only concept (Brevo/Gmail daily cap). Distinguished
                // from a normal short retry/rate-limit delay (never more than
                // ~60s for this job type) by the delay being well past
                // $threshold — only SendSingleMailJob::holdUntilReset()-style
                // holds (until the next midnight reset) push availableDate
                // that far out. See dailyLimitThreshold() for why this
                // doesn't use the mail_daily_limit_exceeded cache flag.
                $query->where('queue', 'email')
                      ->whereNull('reservedDate')->where('attempts', '>', 0)
                      ->where('availableDate', '>', $threshold);
                break;
            case 'stuck':
                $query->where('attempts', '>=', 8);
                // Only hide EMAIL jobs here that are already shown under the
                // 'daily_limit' filter instead (avoids listing them twice).
                // A stuck WhatsApp job must always show under "Stuck" — WA
                // has no daily_limit bucket to overlap with in the first place.
                $query->where(function ($q) use ($threshold) {
                    $q->where('queue', '!=', 'email')
                      ->orWhere('availableDate', '<=', $threshold)
                      ->orWhereNotNull('reservedDate');
                });
                break;
        }

        if ($request->filled('queue') && $request->get('queue') !== 'all') {
            $query->where('queue', $request->get('queue'));
        }

        if ($request->filled('search')) {
            $query->where('payload', 'like', '%' . $request->get('search') . '%');
        }

        $jobs = $query->orderByDesc('ID')->paginate(15);

        $jobs->getCollection()->transform(function ($job) use ($now) {
            $payload            = json_decode($job->payload, true) ?? [];
            $job->job_type      = $this->parseJobType($payload);
            $job->job_full      = $payload['displayName'] ?? 'Unknown';
            $job->job_uuid      = $payload['uuid'] ?? '-';
            $job->job_status    = $this->computeStatus($job, $now);
            $job->mail_info     = $this->extractMailInfo($payload);
            $job->payload_clean = $this->cleanPayload($payload);
            unset($job->payload);
            return $job;
        });

        return response()->json([
            'jobs'                      => $jobs,
            'stats'                     => $this->getStats($now),
            'queues'                    => TrJobQueue::distinct()->pluck('queue'),
            'server_time'               => $now,
            'is_failed_view'            => false,
            'kirimdev_account_status'   => $this->kirimdevAccountStatus(),
            'whatsapp_rate_per_minute'  => (int) env('WHATSAPP_RATE_PER_MINUTE', 8),
        ]);
    }

    private function failedData(Request $request, string $now)
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
            'jobs'                      => $jobs,
            'stats'                     => $this->getStats($now),
            'queues'                    => TrJobQueue::distinct()->pluck('queue'),
            'server_time'               => $now,
            'is_failed_view'            => true,
            'kirimdev_account_status'   => $this->kirimdevAccountStatus(),
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
        $now       = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $threshold = $this->dailyLimitThreshold($now);

        // Don't delete email jobs that are just being held for the Brevo/Gmail
        // daily reset — matches exactly what the "Stuck" filter/count show
        // (see computeStatus()/getStats()), so this button never deletes more
        // than what the admin can see under that status.
        $query = TrJobQueue::where('attempts', '>=', 8)
            ->where(function ($q) use ($threshold) {
                $q->where('queue', '!=', 'email')
                  ->orWhere('availableDate', '<=', $threshold)
                  ->orWhereNotNull('reservedDate');
            });

        $count = $query->delete();
        return response()->json(['success' => true, 'deleted' => $count]);
    }

    private function getStats(string $now): array
    {
        $threshold   = $this->dailyLimitThreshold($now);
        $delayedBase = TrJobQueue::whereNull('reservedDate')->where('availableDate', '>', $now);
        $stuckBase   = TrJobQueue::where('attempts', '>=', 8);

        // Email-only (Brevo/Gmail daily cap) — see dailyLimitThreshold() for
        // why this is derived from the delay itself rather than a live
        // Cache::has() flag. A rate-limited WhatsApp job (attempts>0,
        // availableDate in the near future) is unrelated and never counted here.
        $dailyLimitCount = TrJobQueue::where('queue', 'email')
            ->whereNull('reservedDate')
            ->where('attempts', '>', 0)
            ->where('availableDate', '>', $threshold)
            ->count();

        // Everything else still delayed (any non-email job regardless of
        // attempts, plus email jobs with a short/normal retry delay) stays "Delayed".
        $delayedCount = $delayedBase->count() - $dailyLimitCount;

        // Same email-only exclusion as the 'stuck' filter case in data() —
        // a stuck WhatsApp job must always be counted here.
        $stuckCount = (clone $stuckBase)->where(function ($q) use ($threshold) {
            $q->where('queue', '!=', 'email')
              ->orWhere('availableDate', '<=', $threshold)->orWhereNotNull('reservedDate');
        })->count();

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
            // misleading number if used for ETA math. Deliberately just "not
            // yet reserved" — see dailyLimitThreshold() for why this can't
            // depend on a live cache flag either.
            'email_pending'     => TrJobQueue::where('queue', 'email')->whereNull('reservedDate')->count(),
            'whatsapp_pending'  => TrJobQueue::where('queue', 'whatsapp')->whereNull('reservedDate')->count(),
        ];
    }

    /**
     * Datetime string past which an unreserved, already-attempted email job's
     * delay can only be explained by SendSingleMailJob's Brevo/Gmail
     * daily-limit hold (holdUntilReset(), delayed until the next midnight
     * reset) — never by a normal transient retry.
     *
     * This deliberately does NOT read the 'mail_daily_limit_exceeded' cache
     * flag (Cache::has(), see WaitForMailDailyReset) — that flag only gets
     * refreshed while the worker is actively re-attempting a held job. Once a
     * job is delayed for hours, nothing touches it again until its
     * availableDate arrives, so the flag can lapse/read false in between even
     * though the backlog is still very much there. The job's own recorded
     * delay is a stable signal that isn't subject to that flicker.
     *
     * Ordinary retries for this job type never exceed ~60s (RateLimited's
     * decay window, or SendSingleMailJob::backoff() = [30, 60]), so anything
     * delayed more than 5 minutes out is unambiguously a daily-limit hold.
     */
    private function dailyLimitThreshold(string $now): string
    {
        return Carbon::parse($now)->addMinutes(5)->format('Y-m-d H:i:s');
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

    private function computeStatus($job, string $now): string
    {
        // Email-only concept (Brevo/Gmail daily cap) — see dailyLimitThreshold()
        // for why this is based on the delay itself, not a live cache flag.
        // Without the queue check, a WhatsApp job that got rate-limiter-released
        // (attempts>0, availableDate briefly in the future — completely normal
        // for it) would be mislabeled "Daily Limit", even though the two have
        // nothing to do with each other.
        if ($job->queue === 'email' && is_null($job->reservedDate) && $job->attempts > 0
            && $job->availableDate > $this->dailyLimitThreshold($now)) {
            return 'daily_limit';
        }
        if ($job->attempts >= 8) return 'stuck';
        if (!is_null($job->reservedDate)) return 'processing';
        if ($job->availableDate > $now) return 'delayed';
        return 'pending';
    }

    /**
     * WhatsApp (Kirimdev) phone number status, populated by the
     * kirimdev:check-account-status scheduled command. Null means the cache
     * has never been populated (e.g. right after deploy, or Kirimdev isn't
     * configured yet) — the frontend renders that as "Unknown", not an error.
     */
    private function kirimdevAccountStatus(): ?string
    {
        return Cache::get('kirimdev_account_status');
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
