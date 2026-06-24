<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Therapist extends Model
{
    protected $fillable = [
        'name',
        'specialization',
        'rating',
        'status',
        'image',
    ];

    /**
     * Get the therapist's image.
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (!$value) {
                    return 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=300&q=80';
                }
                if (filter_var($value, FILTER_VALIDATE_URL)) {
                    return $value;
                }
                return asset('storage/' . $value);
            }
        );
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
