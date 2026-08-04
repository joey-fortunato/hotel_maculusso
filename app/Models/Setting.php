<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'value_en', 'group'];

    public static function all_cached(): array
    {
        return Cache::rememberForever('settings.all', fn () => static::query()
            ->get(['key', 'value', 'value_en'])->keyBy('key')->toArray());
    }

    /** Raw base (PT) value regardless of locale. */
    public static function raw(string $key, mixed $default = null): mixed
    {
        return static::all_cached()[$key]['value'] ?? $default;
    }

    /** Raw English value. */
    public static function rawEn(string $key, mixed $default = null): mixed
    {
        return static::all_cached()[$key]['value_en'] ?? $default;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $row = static::all_cached()[$key] ?? null;

        if ($row === null) {
            return $default;
        }

        if (app()->getLocale() === 'en' && ! empty($row['value_en'])) {
            return $row['value_en'];
        }

        return $row['value'] ?? $default;
    }

    public static function put(string $key, ?string $value, string $group = 'general'): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        Cache::forget('settings.all');
    }

    public static function putEn(string $key, ?string $valueEn): void
    {
        static::where('key', $key)->update(['value_en' => $valueEn]);
        Cache::forget('settings.all');
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings.all'));
        static::deleted(fn () => Cache::forget('settings.all'));
    }
}
