<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Prevent clickjacking — only allow iframes from the same origin
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Prevent browser from guessing file type (MIME sniffing)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Enable built-in browser XSS filter
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Limit referrer information sent to other sites
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Restrict access to sensitive browser features
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

        // HSTS: force HTTPS for 1 year (production only)
        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // Content Security Policy: restrict sources for scripts, styles, fonts, and images
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https:",   // allow CDN & inline blade scripts
            "style-src 'self' 'unsafe-inline' https:",                   // allow CDN & inline styles
            "img-src 'self' data: https: blob:",                         // allow CDN images & base64
            "font-src 'self' https: data:",                              // allow Google Fonts etc.
            "connect-src 'self' https:",                                 // allow AJAX to HTTPS
            "media-src 'self' https:",
            "frame-src 'self' https://www.youtube.com https://youtube.com https://www.youtube-nocookie.com https://drive.google.com https://docs.google.com https://www.google.com https://anyflip.com https://www.anyflip.com https://disqus.com https://disquscdn.com https://*.disqus.com https://*.disquscdn.com",  // allow video, doc, maps, flipbook & comment embeds
            "object-src 'none'",                                         // block Flash & plugins
            "base-uri 'self'",                                           // prevent base tag injection
            "form-action 'self'",                                        // forms may only submit to same origin
            "frame-ancestors 'self'",                                    // replaces X-Frame-Options
        ]);
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
