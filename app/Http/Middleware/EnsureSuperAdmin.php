<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user || ! $user->is_admin) {
            return redirect()->route('admin.login');
        }

        if (! $user->is_super_admin) {
            abort(403, 'Acesso reservado ao super administrador.');
        }

        return $next($request);
    }
}
