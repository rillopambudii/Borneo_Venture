<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $fillable = [
        'instagram_url', 'caption', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Normalise an Instagram post/reel URL into a clean permalink
     * suitable for the official embed blockquote.
     */
    public function getEmbedPermalinkAttribute(): string
    {
        $url = trim($this->instagram_url);

        // Strip query string (?igsh=..., ?utm_...) and ensure trailing slash.
        $url = strtok($url, '?');

        return rtrim($url, '/') . '/';
    }
}
