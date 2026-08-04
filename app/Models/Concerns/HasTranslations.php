<?php

namespace App\Models\Concerns;

trait HasTranslations
{
    /** Return the English value when the locale is EN and it is filled; otherwise the base (PT) value. */
    public function tr(string $field): mixed
    {
        if (app()->getLocale() === 'en') {
            $en = $this->{$field.'_en'} ?? null;
            $filled = is_array($en) ? ! empty($en) : ($en !== null && $en !== '');
            if ($filled) {
                return $en;
            }
        }

        return $this->{$field};
    }
}
