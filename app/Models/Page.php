<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasTranslations;

    protected $guarded = ['id'];
    protected $casts = ['sections' => 'array', 'sections_en' => 'array'];
}
