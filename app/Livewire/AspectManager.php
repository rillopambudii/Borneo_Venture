<?php

namespace App\Livewire;

use App\Livewire\Concerns\ManagesSectionImages;
use App\Models\ExplorationAspect;
use Livewire\Component;
use Livewire\WithFileUploads;

class AspectManager extends Component
{
    use WithFileUploads;
    use ManagesSectionImages;

    public ?int $editingId = null;

    public string $icon = '🌿';
    public string $title = '';
    public string $description = '';
    public bool $is_active = true;

    protected function imageFolder(): string
    {
        return 'aspects';
    }

    protected function rules(): array
    {
        return [
            'icon' => ['required', 'string', 'max:8'],
            'title' => ['required', 'string', 'max:120'],
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
        $aspect = ExplorationAspect::findOrFail($id);

        $this->editingId = $aspect->id;
        $this->icon = $aspect->icon;
        $this->title = $aspect->title;
        $this->description = $aspect->description;
        $this->is_active = $aspect->is_active;
        $this->newImages = [];
        $this->resetValidation();
    }

    public function save(): void
    {
        $data = $this->validate();

        $aspect = $this->editingId
            ? tap(ExplorationAspect::findOrFail($this->editingId))->update([
                'icon' => $data['icon'],
                'title' => $data['title'],
                'description' => $data['description'],
                'is_active' => $data['is_active'],
            ])
            : ExplorationAspect::create([
                'icon' => $data['icon'],
                'title' => $data['title'],
                'description' => $data['description'],
                'is_active' => $data['is_active'],
                'sort_order' => (ExplorationAspect::max('sort_order') ?? 0) + 1,
            ]);

        $this->saveNewImagesFor($aspect);

        session()->flash('status', $this->editingId ? 'Aspek diperbarui.' : 'Aspek ditambahkan.');
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->reset(['editingId', 'icon', 'title', 'description', 'is_active', 'newImages']);
        $this->icon = '🌿';
        $this->is_active = true;
        $this->resetValidation();
    }

    public function toggle(int $id): void
    {
        $aspect = ExplorationAspect::findOrFail($id);
        $aspect->update(['is_active' => ! $aspect->is_active]);
    }

    public function delete(int $id): void
    {
        ExplorationAspect::findOrFail($id)->delete();

        if ($this->editingId === $id) {
            $this->resetForm();
        }

        session()->flash('status', 'Aspek dihapus.');
    }

    public function moveUp(int $id): void
    {
        $this->swapAspect($id, 'up');
    }

    public function moveDown(int $id): void
    {
        $this->swapAspect($id, 'down');
    }

    private function swapAspect(int $id, string $direction): void
    {
        $current = ExplorationAspect::findOrFail($id);

        $neighbour = ExplorationAspect::query()
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
        return view('livewire.aspect-manager', [
            'aspects' => ExplorationAspect::with('images')->orderBy('sort_order')->orderBy('id')->get(),
            'editingImages' => $this->editingId
                ? ExplorationAspect::findOrFail($this->editingId)->images
                : collect(),
        ]);
    }
}
