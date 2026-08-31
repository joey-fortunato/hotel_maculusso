<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    /**
     * Fetch a CMS setting value (cached).
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('lroute')) {
    /**
     * Locale-aware route URL. Portuguese (default) has no prefix; English → /en.
     * Pass named route params in $params (never the locale). Defaults to the
     * current app locale, or override it (e.g. the language switcher).
     */
    function lroute(string $name, array $params = [], ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        // English routes are registered with an "en." name prefix; PT keeps base names.
        return route($locale === 'en' ? 'en.'.$name : $name, $params);
    }
}

if (! function_exists('img_src')) {
    /**
     * Resolve a CMS image value that may be an external URL or a stored path.
     */
    function img_src(?string $value, ?string $fallback = null): ?string
    {
        $value = $value ?: $fallback;
        if (! $value) {
            return null;
        }

        return \Illuminate\Support\Str::startsWith($value, ['http://', 'https://', '//'])
            ? $value
            : asset(ltrim($value, '/'));
    }
}
