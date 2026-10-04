<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LaravelLogController extends Controller
{
    /**
     * Project's logging channel is 'single' (config/logging.php) — one
     * unrotated file. It can grow unbounded, so reading is capped to the
     * tail of the file to avoid loading an enormous file into memory.
     */
    private const MAX_READ_BYTES = 10 * 1024 * 1024; // 10MB

    private function logPath(): string
    {
        return storage_path('logs/laravel.log');
    }

    public function index()
    {
        return view('admin-page.laravel-log.index')
            ->with('title', 'Laravel Log');
    }

    public function data(Request $request)
    {
        $path = $this->logPath();

        if (!file_exists($path)) {
            return response()->json([
                'entries'    => ['data' => [], 'current_page' => 1, 'last_page' => 1, 'total' => 0, 'from' => 0, 'to' => 0],
                'stats'      => $this->emptyStats(),
                'file_size'  => 0,
                'truncated'  => false,
                'updated_at' => null,
            ]);
        }

        [$raw, $truncated] = $this->readTail($path);
        $allEntries = $this->parseEntries($raw);

        $level  = $request->get('level', 'all');
        $search = trim((string) $request->get('search', ''));

        $filtered = array_values(array_filter($allEntries, function ($entry) use ($level, $search) {
            if ($level !== 'all' && strtoupper($entry['level']) !== strtoupper($level)) {
                return false;
            }
            if ($search !== '' && stripos($entry['body'], $search) === false) {
                return false;
            }
            return true;
        }));

        // Newest first.
        $filtered = array_reverse($filtered);

        $perPage     = 20;
        $total       = count($filtered);
        $page        = max(1, (int) $request->get('page', 1));
        $lastPage    = max(1, (int) ceil($total / $perPage));
        $page        = min($page, $lastPage);
        $offset      = ($page - 1) * $perPage;
        $pageEntries = array_slice($filtered, $offset, $perPage);

        // Trim the stack trace / context body for list display — full body
        // is still available via the modal through the same payload.
        foreach ($pageEntries as &$entry) {
            $entry['excerpt'] = \Illuminate\Support\Str::limit($entry['body'], 300);
        }
        unset($entry);

        return response()->json([
            'entries' => [
                'data'         => $pageEntries,
                'current_page' => $page,
                'last_page'    => $lastPage,
                'total'        => $total,
                'from'         => $total > 0 ? $offset + 1 : 0,
                'to'           => min($offset + $perPage, $total),
            ],
            'stats'      => $this->computeStats($allEntries),
            'file_size'  => filesize($path),
            'truncated'  => $truncated,
            'updated_at' => date('Y-m-d H:i:s', filemtime($path)),
        ]);
    }

    public function clear(Request $request)
    {
        $path = $this->logPath();

        if (!file_exists($path)) {
            return response()->json(['success' => true, 'message' => 'Log file is already empty.']);
        }

        $clearedBy = auth()->user()->email ?? 'unknown';
        $ip        = $request->ip();

        file_put_contents($path, '');

        // Written after truncation so this accountability line survives as
        // the first thing in the freshly-emptied file, instead of being
        // wiped out by the truncate itself.
        Log::info('[LaravelLog] Log cleared by ' . $clearedBy . ' from IP: ' . $ip);

        return response()->json(['success' => true]);
    }

    public function download()
    {
        $path = $this->logPath();

        if (!file_exists($path)) {
            abort(404, 'Log file not found.');
        }

        return response()->download($path, 'laravel-' . date('Y-m-d_His') . '.log');
    }

    /**
     * Read the file, capped to the last MAX_READ_BYTES to protect memory on
     * an unrotated log that's grown very large.
     */
    private function readTail(string $path): array
    {
        $size = filesize($path);
        if ($size <= self::MAX_READ_BYTES) {
            return [file_get_contents($path), false];
        }

        $handle = fopen($path, 'r');
        fseek($handle, -self::MAX_READ_BYTES, SEEK_END);
        $contents = fread($handle, self::MAX_READ_BYTES);
        fclose($handle);

        // Drop the first (likely partial) line so parsing doesn't choke on
        // a truncated entry header.
        $firstBreak = strpos($contents, "\n[");
        if ($firstBreak !== false) {
            $contents = substr($contents, $firstBreak + 1);
        }

        return [$contents, true];
    }

    /**
     * Laravel's default monolog line format: "[YYYY-MM-DD HH:MM:SS] env.LEVEL: message".
     * Everything until the next entry header (stack trace, context JSON) is
     * folded into that entry's body.
     */
    private function parseEntries(string $raw): array
    {
        if (trim($raw) === '') {
            return [];
        }

        $pattern = '/^\[(\d{4}-\d{2}-\d{2}[ T]\d{2}:\d{2}:\d{2}(?:\.\d+)?(?:[+-]\d{2}:?\d{2})?)\] (\w+)\.(\w+): /m';

        preg_match_all($pattern, $raw, $matches, PREG_OFFSET_CAPTURE);

        $entries = [];
        $count   = count($matches[0]);

        for ($i = 0; $i < $count; $i++) {
            $start    = $matches[0][$i][1];
            $end      = $i + 1 < $count ? $matches[0][$i + 1][1] : strlen($raw);
            $headerLen = strlen($matches[0][$i][0]);

            $body = trim(substr($raw, $start + $headerLen, $end - $start - $headerLen));

            $entries[] = [
                'timestamp' => $matches[1][$i][0],
                'env'       => $matches[2][$i][0],
                'level'     => strtoupper($matches[3][$i][0]),
                'body'      => $body,
            ];
        }

        return $entries;
    }

    private function computeStats(array $entries): array
    {
        $stats = $this->emptyStats();
        $stats['total'] = count($entries);

        foreach ($entries as $entry) {
            $key = strtolower($entry['level']);
            if (array_key_exists($key, $stats)) {
                $stats[$key]++;
            }
        }

        return $stats;
    }

    private function emptyStats(): array
    {
        return [
            'total'     => 0,
            'emergency' => 0,
            'alert'     => 0,
            'critical'  => 0,
            'error'     => 0,
            'warning'   => 0,
            'notice'    => 0,
            'info'      => 0,
            'debug'     => 0,
        ];
    }
}
