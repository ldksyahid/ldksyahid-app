<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifyBisabillerIp
{
    public function handle(Request $request, Closure $next)
    {
        $allowed = config('services.bisatopup.allowed_ips', []);

        if (!empty($allowed) && !in_array($request->ip(), $allowed)) {
            Log::warning('[BisabillerCallback] blocked — IP not in allowlist', [
                'ip'   => $request->ip(),
                'path' => $request->path(),
            ]);
            return response()->json(['status' => 'forbidden'], 403);
        }

        return $next($request);
    }
}
