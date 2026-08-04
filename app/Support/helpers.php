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
