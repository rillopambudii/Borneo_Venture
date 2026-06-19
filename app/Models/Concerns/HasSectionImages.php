<?php

namespace App\Models\Concerns;

use App\Models\SectionImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasSectionImages
{
    public static function bootHasSectionImages(): void
    {
        // Clean up image files & rows when the parent is deleted.
        static::deleting(function ($model) {
            foreach ($model->images as $image) {
                if (! Str::startsWith($image->path, ['http://', 'https://', '/'])) {
                    Storage::disk('public')->delete($image->path);
                }
                $image->delete();
            }
        });
    }

    public function images()
    {
        return $this->morphMany(SectionImage::class, 'imageable')->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Ordered list of image URLs, ready for the front-end carousel.
     *
     * @return array<int, string>
     */
    public function getImageUrlsAttribute(): array
    {
        return $this->images->map->url->values()->all();
    }
}
