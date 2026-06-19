<?php

namespace App\Livewire\Concerns;

use App\Models\SectionImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Shared multi-image upload / reorder / delete behaviour for the admin
 * content managers. The host component must use Livewire\WithFileUploads,
 * expose a public array `$newImages`, and define `imageFolder()`.
 */
trait ManagesSectionImages
{
    /** @var array<int, \Livewire\Features\SupportFileUploads\TemporaryUploadedFile> */
    public array $newImages = [];

    /** Sub-folder (on the "public" disk) where uploads are stored. */
    abstract protected function imageFolder(): string;

    /** Persist any freshly uploaded files as SectionImage rows for $model. */
    protected function saveNewImagesFor(Model $model): void
    {
        if (empty($this->newImages)) {
            return;
        }

        $next = ($model->images()->max('sort_order') ?? 0) + 1;

        foreach ($this->newImages as $file) {
            $path = $file->store($this->imageFolder(), 'public');

            $model->images()->create([
                'path' => $path,
                'sort_order' => $next++,
            ]);
        }

        $this->newImages = [];
    }

    public function removeNewImage(int $index): void
    {
        unset($this->newImages[$index]);
        $this->newImages = array_values($this->newImages);
    }

    public function deleteImage(int $imageId): void
    {
        $image = SectionImage::findOrFail($imageId);

        if (! Str::startsWith($image->path, ['http://', 'https://', '/'])) {
            Storage::disk('public')->delete($image->path);
        }

        $image->delete();
    }

    public function moveImageUp(int $imageId): void
    {
        $this->swapImage($imageId, 'up');
    }

    public function moveImageDown(int $imageId): void
    {
        $this->swapImage($imageId, 'down');
    }

    private function swapImage(int $imageId, string $direction): void
    {
        $current = SectionImage::findOrFail($imageId);

        $neighbour = SectionImage::query()
            ->where('imageable_type', $current->imageable_type)
            ->where('imageable_id', $current->imageable_id)
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
}
