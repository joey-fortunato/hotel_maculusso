<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['checkin' => 'date', 'checkout' => 'date'];

    public function getNightsAttribute(): int
    {
        return max(0, $this->checkin->diffInDays($this->checkout));
    }
}
