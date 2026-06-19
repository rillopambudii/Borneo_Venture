<?php

namespace App\Livewire;

use App\Livewire\Concerns\ManagesSectionImages;
use App\Models\AboutSection;
use Livewire\Component;
use Livewire\WithFileUploads;

class AboutManager extends Component
{
    use WithFileUploads;
    use ManagesSectionImages;

    public int $aboutId;

    public string $eyebrow = 'Tentang Kami';
    public string $title = '';
    public string $body = '';
    public string $badge_title = '';
    public string $badge_subtitle = '';
    public string $tags = '';

    protected function imageFolder(): string
    {
        return 'about';
    }

    public function mount(): void
    {
        $about = AboutSection::first() ?? AboutSection::create([
            'eyebrow' => 'Tentang Kami',
            'title' => 'Dari Samarinda ke Pedalaman Kalimantan',
            'body' => '',
        ]);

        $this->aboutId = $about->id;
        $this->eyebrow = $about->eyebrow;
        $this->title = $about->title;
        $this->body = $about->body;
        $this->badge_title = $about->badge_title ?? '';
        $this->badge_subtitle = $about->badge_subtitle ?? '';
        $this->tags = collect($about->tags ?? [])->implode(', ');
    }

    protected function rules(): array
    {
        return [
            'eyebrow' => ['required', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:160'],
            'body' => ['required', 'string', 'max:3000'],
            'badge_title' => ['nullable', 'string', 'max:60'],
            'badge_subtitle' => ['nullable', 'string', 'max:120'],
            'tags' => ['nullable', 'string', 'max:255'],
            'newImages' => ['array'],
            'newImages.*' => ['image', 'max:12288'],
        ];
    }

    protected $messages = [
        'newImages.*.image' => 'File harus berupa gambar (jpg, png, webp).',
        'newImages.*.max' => 'Ukuran tiap gambar maksimal 12 MB.',
    ];

    public function save(): void
    {
        $data = $this->validate();

        $tags = collect(explode(',', $data['tags'] ?? ''))
            ->map(fn ($t) => trim($t))
            ->filter()
            ->values()
            ->all();

        $about = AboutSection::findOrFail($this->aboutId);
        $about->update([
            'eyebrow' => $data['eyebrow'],
            'title' => $data['title'],
            'body' => $data['body'],
            'badge_title' => $data['badge_title'] ?: null,
            'badge_subtitle' => $data['badge_subtitle'] ?: null,
            'tags' => $tags,
        ]);

        $this->saveNewImagesFor($about);

        session()->flash('status', 'Bagian "Tentang Kami" diperbarui.');
    }

    public function render()
    {
        $about = AboutSection::with('images')->findOrFail($this->aboutId);

        return view('livewire.about-manager', [
            'images' => $about->images,
        ]);
    }
}
