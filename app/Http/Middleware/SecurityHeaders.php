<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Cegah clickjacking — hanya izinkan iframe dari domain sendiri
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Cegah browser menebak tipe file (MIME sniffing)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Aktifkan filter XSS bawaan browser
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Batasi informasi referrer yang dikirim ke situs lain
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Batasi akses fitur browser berbahaya
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

        // HSTS: paksa HTTPS selama 1 tahun (hanya aktif di production)
        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
