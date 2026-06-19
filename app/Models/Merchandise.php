<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchandise extends Model
{
    protected $table = 'merchandise';

    protected $fillable = [
        'name', 'description', 'price', 'stock', 'image', 'category', 'sizes', 'is_active',
    ];

    protected $casts = [
        'sizes' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function getPriceFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
