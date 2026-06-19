<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'name', 'description', 'location', 'duration', 'duration_days',
        'price', 'max_participants', 'difficulty', 'image', 'includes', 'is_active',
    ];

    protected $casts = [
        'includes' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getPriceFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
