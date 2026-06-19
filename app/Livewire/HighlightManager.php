<?php

namespace App\Livewire;

use App\Livewire\Concerns\ManagesSectionImages;
use App\Models\Highlight;
use Livewire\Component;
use Livewire\WithFileUploads;

class HighlightManager extends Component
{
    use WithFileUploads;
    use ManagesSectionImages;

    public ?int $editingId = null;

    public string $title = '';
    public string $location = '';
    public string $description = '';
    public bool $is_active = true;

    protected function imageFolder(): string
    {
        return 'highlights';
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'location' => ['nullable', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:1000'],
            'is_active' => ['boolean'],
            'newImages' => ['array'],
            'newImages.*' => ['image', 'max:12288'],
        ];
    }

    protected $messages = [
        'newImages.*.image' => 'File harus berupa gambar (jpg, png, webp).',
        'newImages.*.max' => 'Ukuran tiap gambar maksimal 12 MB.',
    ];

    public function edit(int $id): void
    {
        $highlight = Highlight::findOrFail($id);

        $this->editingId = $highlight->id;
        $this->title = $highlight->title;
        $this->location = $highlight->location ?? '';
        $this->description = $highlight->description;
        $this->is_active = $highlight->is_active;
        $this->newImages = [];
        $this->resetValidation();
    }

    public function save(): void
    {
        $data = $this->validate();

        $payload = [
            'title' => $data['title'],
            'location' => $data['location'] ?: null,
            'description' => $data['description'],
            'is_active' => $data['is_active'],
        ];

        $highlight = $this->editingId
            ? tap(Highlight::findOrFail($this->editingId))->update($payload)
            : Highlight::create($payload + ['sort_order' => (Highlight::max('sort_order') ?? 0) + 1]);

        $this->saveNewImagesFor($highlight);

        session()->flash('status', $this->editingId ? 'Destinasi diperbarui.' : 'Destinasi ditambahkan.');
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->reset(['editingId', 'title', 'location', 'description', 'is_active', 'newImages']);
        $this->is_active = true;
        $this->resetValidation();
    }

    public function toggle(int $id): void
    {
        $highlight = Highlight::findOrFail($id);
        $highlight->update(['is_active' => ! $highlight->is_active]);
    }

    public function delete(int $id): void
    {
        Highlight::findOrFail($id)->delete();

        if ($this->editingId === $id) {
            $this->resetForm();
        }

        session()->flash('status', 'Destinasi dihapus.');
    }

    public function moveUp(int $id): void
    {
        $this->swapHighlight($id, 'up');
    }

    public function moveDown(int $id): void
    {
        $this->swapHighlight($id, 'down');
    }

    private function swapHighlight(int $id, string $direction): void
    {
        $current = Highlight::findOrFail($id);

        $neighbour = Highlight::query()
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
        return view('livewire.highlight-manager', [
            'highlights' => Highlight::with('images')->orderBy('sort_order')->orderBy('id')->get(),
            'editingImages' => $this->editingId
                ? Highlight::findOrFail($this->editingId)->images
                : collect(),
        ]);
    }
}
