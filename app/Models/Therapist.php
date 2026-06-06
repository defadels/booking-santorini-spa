<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Therapist extends Model
{
    protected $fillable = [
        'name',
        'specialization',
        'rating',
        'status',
        'image',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
