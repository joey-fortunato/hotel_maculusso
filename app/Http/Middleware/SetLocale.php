<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Portuguese is the default and carries no URL prefix; English lives under /en.
 * The first URL segment is "en" only for the English pages.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->segment(1) === 'en' ? 'en' : 'pt';

        app()->setLocale($locale);
        View::share('locale', $locale);

        return $next($request);
    }
}
