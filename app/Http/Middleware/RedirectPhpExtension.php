<?php

namespace App\Http\Middleware;

use App\Services\RedirectResolver;
use Closure;
use Illuminate\Http\Request;

class RedirectPhpExtension
{
    public function __construct(private RedirectResolver $redirects) {}

    public function handle(Request $request, Closure $next)
    {
        $path = $request->getPathInfo();

        if (! str_ends_with(strtolower($path), '.php') || ! $request->isMethodSafe()) {
            return $next($request);
        }

        $clean = substr($path, 0, -4);
        $clean = preg_replace('#/index$#i', '', $clean);
        $clean = $clean === '' ? '/' : $clean;

        $hit = $this->redirects->resolve($clean);
        $target = ($hit && $hit['code'] !== 410) ? $hit['to'] : $clean;

        $qs = $request->getQueryString();
        $url = $target . ($qs ? (str_contains($target, '?') ? '&' : '?') . $qs : '');

        return redirect()->to($url, 301);
    }
}
