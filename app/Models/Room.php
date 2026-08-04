<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasTranslations;

    protected $guarded = ['id'];

    protected $casts = [
        'amenities' => 'array',
        'amenities_en' => 'array',
        'gallery' => 'array',
        'is_published' => 'boolean',
    ];

    public function scopePublished($q) { return $q->where('is_published', true); }
    public function scopeOrdered($q) { return $q->orderBy('sort')->orderBy('id'); }

    public function guestsLabel(): string
    {
        $en = app()->getLocale() === 'en';
        $word = $this->max_guests == 1 ? ($en ? 'guest' : 'hóspede') : ($en ? 'guests' : 'hóspedes');

        return $this->max_guests.' '.$word;
    }

    public function detailLine(): string
    {
        return collect([$this->guestsLabel(), $this->size, $this->tr('bed')])->filter()->implode(' · ');
    }
}
