<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\ExplorationAspect;
use App\Models\Highlight;

class HomeController extends Controller
{
    public function index()
    {
        $aspects = ExplorationAspect::with('images')
            ->where('is_active', true)
            ->orderBy('sort_order')->orderBy('id')
            ->get();

        // Shape for the interactive Alpine selector on the front-end.
        $aspectsData = $aspects->map(fn ($a) => [
            'icon' => $a->icon,
            'title' => $a->title,
            'desc' => $a->description,
            'images' => $a->image_urls,
        ])->values();

        $highlights = Highlight::with('images')
            ->where('is_active', true)
            ->orderBy('sort_order')->orderBy('id')
            ->get();

        $about = AboutSection::with('images')->first();

        return view('home', compact('aspects', 'aspectsData', 'highlights', 'about'));
    }
}
