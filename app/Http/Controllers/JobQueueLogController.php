<?php

namespace App\Http\Controllers;

use App\Models\TrJobQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class JobQueueLogController extends Controller
{
    public function index()
    {
        return view('admin-page.email-config.job-queue-log.index')
            ->with('title', 'Job Queue Log');
    }

    public function data(Request $request)
    {
        $now               = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $dailyLimitActive  = $this->isGmailDailyLimitActive();
        $query             = TrJobQueue::query();

        switch ($request->get('status', 'all')) {
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
                $query->whereNull('reservedDate')->where('availableDate', '>', $now)->where('attempts', '>', 0);
                break;
            case 'stuck':
                $query->where('attempts', '>=', 8);
                if ($dailyLimitActive) {
                    $query->where(function ($q) use ($now) {
                        $q->where('availableDate', '<=', $now)
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
            return $job;
        });

        return response()->json([
            'jobs'              => $jobs,
            'stats'             => $this->getStats($now, $dailyLimitActive),
            'queues'            => TrJobQueue::distinct()->pluck('queue'),
            'server_time'       => $now,
            'gmail_daily_limit' => $dailyLimitActive,
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
            $dailyLimitCount = (clone $delayedBase)->where('attempts', '>', 0)->count();
            $delayedCount    = (clone $delayedBase)->where('attempts', 0)->count();
            $stuckCount      = (clone $stuckBase)->where(function ($q) use ($now) {
                $q->where('availableDate', '<=', $now)->orWhereNotNull('reservedDate');
            })->count();
        } else {
            $delayedCount = $delayedBase->count();
            $stuckCount   = $stuckBase->count();
        }

        return [
            'total'       => TrJobQueue::count(),
            'pending'     => TrJobQueue::whereNull('reservedDate')->where('availableDate', '<=', $now)->count(),
            'processing'  => TrJobQueue::whereNotNull('reservedDate')->count(),
            'delayed'     => $delayedCount,
            'stuck'       => $stuckCount,
            'daily_limit' => $dailyLimitCount,
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
        if ($dailyLimitActive && $job->availableDate > $now && is_null($job->reservedDate) && $job->attempts > 0) {
            return 'daily_limit';
        }
        if ($job->attempts >= 8) return 'stuck';
        if (!is_null($job->reservedDate)) return 'processing';
        if ($job->availableDate > $now) return 'delayed';
        return 'pending';
    }

    private function isGmailDailyLimitActive(): bool
    {
        return Cache::has('gmail_daily_limit_exceeded');
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
