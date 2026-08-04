<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSiteAvailable
{
    public function handle(Request $request, Closure $next): Response
    {
        $isAdmin = Auth::check() && Auth::user()->is_admin;

        if (setting('maintenance_mode') === '1' && ! $isAdmin) {
            return response()->view('public.maintenance', [], 503);
        }

        return $next($request);
    }
}
