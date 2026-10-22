<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $h = $response->headers;

        $h->set('X-Content-Type-Options', 'nosniff');
        $h->set('X-Frame-Options', 'SAMEORIGIN');
        $h->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $h->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');
        $h->remove('X-Powered-By');

        if ($request->isSecure()) {
            $h->set('Strict-Transport-Security', 'max-age=' . config('security.hsts_max_age', 300));
        }

        $h->set('Content-Security-Policy-Report-Only', implode('; ', [
            "default-src 'self'",
            "script-src 'self' https://www.google.com https://www.gstatic.com https://www.clarity.ms https://t.contentsquare.net",
            "img-src 'self' data: https:",
            "style-src 'self' 'unsafe-inline'",
            "frame-src https://www.google.com",
            "connect-src 'self' https://*.clarity.ms https://*.contentsquare.net",
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self'",
            'upgrade-insecure-requests',
        ]));

        return $response;
    }
}
