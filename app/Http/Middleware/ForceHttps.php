<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
{
    public function handle(Request $request, Closure $next)
    {
        // Only active in production and when the request is not already HTTPS
        if (app()->environment('production') && !$request->secure()) {
            // 308 preserves the HTTP method (POST stays POST); 301 would convert POST to GET
            return redirect()->secure($request->getRequestUri(), 308);
        }

        return $next($request);
    }
}
