<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

/**
 * Lightweight, dependency-free bot protection for public forms.
 *
 * Two layers, no external service or CAPTCHA:
 *  1. Honeypot  — a hidden "website" field that humans never fill. If filled → bot.
 *  2. Time-trap — a signed "_ts" render timestamp. Submissions that arrive faster
 *     than $minSeconds (scripted) or on a stale token (older than 3h) are rejected.
 *
 * Usage: `->middleware('bot-guard')` (full) or `bot-guard:0` (honeypot only,
 * e.g. login, where password managers can autofill instantly).
 *
 * Pair with `throttle:` for flood / brute-force protection.
 */
final class BotGuard
{
    /** Maximum age of a form token before it is considered stale (seconds). */
    private const MAX_AGE = 60 * 60 * 3;

    public function handle(Request $request, Closure $next, int|string $minSeconds = 2): Response
    {
        $min = (int) $minSeconds;

        // 1) Honeypot — must be empty.
        if (filled($request->input('website'))) {
            return $this->reject($request);
        }

        // 2) Time-trap — only when a minimum interval is enforced.
        if ($min > 0) {
            $time = $this->readTimestamp($request->input('_ts'));

            if ($time === null) {
                return $this->reject($request);
            }

            $age = time() - $time;
            if ($age < $min || $age > self::MAX_AGE) {
                return $this->reject($request);
            }
        }

        return $next($request);
    }

    private function readTimestamp(mixed $value): ?int
    {
        if (! is_string($value) || $value === '') {
            return null;
        }

        try {
            return (int) Crypt::decryptString($value);
        } catch (\Throwable) {
            return null;
        }
    }

    private function reject(Request $request): Response
    {
        $message = __('Não foi possível validar o envio. Recarregue a página e tente novamente.');

        if ($request->expectsJson()) {
            return response()->json(['ok' => false, 'message' => $message], 422);
        }

        return back()
            ->withInput($request->except('website', '_ts', 'password'))
            ->withErrors(['email' => $message]);
    }
}
