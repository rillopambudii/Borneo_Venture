<?php

namespace App\Models;

use App\Models\Concerns\HasSectionImages;
use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    use HasSectionImages;

    protected $fillable = [
        'eyebrow', 'title', 'body', 'badge_title', 'badge_subtitle', 'tags',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    /**
     * Body paragraphs (split on blank lines) for rendering.
     *
     * @return array<int, string>
     */
    public function getParagraphsAttribute(): array
    {
        return collect(preg_split('/\n\s*\n/', trim((string) $this->body)))
            ->map(fn ($p) => trim($p))
            ->filter()
            ->values()
            ->all();
    }
}
