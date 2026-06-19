<?php

namespace App\Models;

use App\Models\Concerns\HasSectionImages;
use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    use HasSectionImages;

    protected $fillable = [
        'title', 'location', 'description', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
