<?php

namespace App\Livewire;

use App\Models\GalleryItem;
use Livewire\Component;

class GalleryManager extends Component
{
    public string $instagram_url = '';
    public string $caption = '';

    protected function rules(): array
    {
        return [
            'instagram_url' => ['required', 'url', 'regex:#instagram\.com/(p|reel|tv)/#i'],
            'caption' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected $messages = [
        'instagram_url.regex' => 'URL harus berupa link postingan/reel Instagram (mis. https://www.instagram.com/p/XXXX/).',
    ];

    public function add(): void
    {
        $data = $this->validate();

        GalleryItem::create([
            'instagram_url' => $data['instagram_url'],
            'caption' => $data['caption'] ?: null,
            'sort_order' => (GalleryItem::max('sort_order') ?? 0) + 1,
            'is_active' => true,
        ]);

        $this->reset(['instagram_url', 'caption']);
        session()->flash('status', 'Postingan ditambahkan ke galeri.');
    }

    public function toggle(int $id): void
    {
        $item = GalleryItem::findOrFail($id);
        $item->update(['is_active' => ! $item->is_active]);
    }

    public function delete(int $id): void
    {
        GalleryItem::findOrFail($id)->delete();
        session()->flash('status', 'Postingan dihapus.');
    }

    public function moveUp(int $id): void
    {
        $this->swapWithNeighbour($id, 'up');
    }

    public function moveDown(int $id): void
    {
        $this->swapWithNeighbour($id, 'down');
    }

    private function swapWithNeighbour(int $id, string $direction): void
    {
        $current = GalleryItem::findOrFail($id);

        $neighbour = GalleryItem::query()
            ->when($direction === 'up',
                fn ($q) => $q->where('sort_order', '<', $current->sort_order)->orderByDesc('sort_order'),
                fn ($q) => $q->where('sort_order', '>', $current->sort_order)->orderBy('sort_order'))
            ->first();

        if (! $neighbour) {
            return;
        }

        $tmp = $current->sort_order;
        $current->update(['sort_order' => $neighbour->sort_order]);
        $neighbour->update(['sort_order' => $tmp]);
    }

    public function render()
    {
        return view('livewire.gallery-manager', [
            'items' => GalleryItem::orderBy('sort_order')->orderByDesc('id')->get(),
        ]);
    }
}
