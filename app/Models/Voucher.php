<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'name',
        'discount_percent',
        'quota',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_active'  => 'boolean',
    ];

    /**
     * Scope: Voucher yang tersedia untuk customer
     * (aktif, dalam rentang tanggal, dan masih ada sisa kuota).
     */
    public function scopeAvailable($query)
    {
        $today = Carbon::today();
        return $query
            ->where('is_active', true)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->whereColumn('used_count', '<', 'quota');
    }

    /**
     * Cek apakah voucher ini masih valid untuk digunakan.
     */
    public function isValid(): bool
    {
        $today = Carbon::today();
        return $this->is_active
            && $this->start_date->lte($today)
            && $this->end_date->gte($today)
            && $this->used_count < $this->quota;
    }

    /**
     * Sisa kuota voucher.
     */
    public function getRemainingQuota(): int
    {
        return max(0, $this->quota - $this->used_count);
    }

    /**
     * Relasi: satu voucher bisa dipakai oleh banyak booking.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
