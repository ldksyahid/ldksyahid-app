<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NoCacheAjax
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->ajax() || $request->wantsJson() || $response instanceof JsonResponse) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        return $response;
    }
}
