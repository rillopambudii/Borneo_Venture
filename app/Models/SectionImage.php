<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SectionImage extends Model
{
    protected $fillable = [
        'imageable_type', 'imageable_id', 'path', 'alt', 'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * Public URL for the image. Supports both uploaded files (stored on the
     * "public" disk) and seeded absolute/root-relative URLs.
     */
    public function getUrlAttribute(): string
    {
        $path = $this->path;

        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
