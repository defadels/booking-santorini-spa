<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'duration',
        'price',
        'category',
        'image',
        'is_available',
        'total_bookings',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
