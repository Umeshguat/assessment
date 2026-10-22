<?php

use App\Http\Middleware\RedirectPhpExtension;
use App\Http\Middleware\SecurityHeaders;
use App\Services\RedirectResolver;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prepend(RedirectPhpExtension::class);   
        $middleware->append(SecurityHeaders::class);          
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if (! $request->isMethodSafe()) {
                return null;
            }

            $hit = app(RedirectResolver::class)->resolve($request->getPathInfo());
            if (! $hit) {
                return null;                                  
            }

            DB::table('redirects')->where('id', $hit['id'])->increment('hits');

            if ($hit['code'] === 410) {
                return response('Gone', 410);
            }

            $qs = $request->getQueryString();
            return redirect()->to($hit['to'] . ($qs ? (str_contains($hit['to'], '?') ? '&' : '?') . $qs : ''), $hit['code']);
        });
    })->create();
