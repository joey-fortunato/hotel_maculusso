<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class RestaurantItem extends Model
{
    use HasTranslations;

    protected $table = 'restaurant_items';
    protected $guarded = ['id'];
    protected $casts = ['is_published' => 'boolean', 'tall' => 'boolean'];

    public function scopePublished($q) { return $q->where('is_published', true); }
    public function scopeOrdered($q) { return $q->orderBy('sort')->orderBy('id'); }
}
