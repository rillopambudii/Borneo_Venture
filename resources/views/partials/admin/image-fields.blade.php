{{-- Shared multi-image manager UI for the admin content managers.
     Expects: $existing (Collection<SectionImage>) — current saved images.
     Relies on the host Livewire component using the ManagesSectionImages trait
     (newImages, removeNewImage, deleteImage, moveImageUp/Down). --}}
<div class="space-y-4">
    <label class="block text-forest-200/80 text-sm">Gambar <span class="text-forest-200/40">(bisa lebih dari satu)</span></label>

    {{-- Existing saved images --}}
    @if ($existing->isNotEmpty())
        <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
            @foreach ($existing as $image)
                <div class="relative group rounded-xl overflow-hidden border border-forest-600" wire:key="img-{{ $image->id }}">
                    <img src="{{ $image->url }}" alt="" class="w-full h-24 object-cover" />
                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <button type="button" wire:click="moveImageUp({{ $image->id }})" title="Geser kiri" class="text-white hover:text-forest-300 text-lg {{ $loop->first ? 'opacity-30 pointer-events-none' : '' }}">←</button>
                        <button type="button" wire:click="deleteImage({{ $image->id }})" wire:confirm="Hapus gambar ini?" title="Hapus" class="text-red-300 hover:text-red-200 text-lg">✕</button>
                        <button type="button" wire:click="moveImageDown({{ $image->id }})" title="Geser kanan" class="text-white hover:text-forest-300 text-lg {{ $loop->last ? 'opacity-30 pointer-events-none' : '' }}">→</button>
                    </div>
                    @if ($loop->first)
                        <span class="absolute top-1 left-1 bg-forest-500 text-white text-[10px] px-1.5 py-0.5 rounded">Utama</span>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- Newly picked (not yet saved) previews --}}
    @if (!empty($newImages))
        <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
            @foreach ($newImages as $i => $img)
                <div class="relative group rounded-xl overflow-hidden border border-dashed border-forest-400" wire:key="new-img-{{ $i }}">
                    @if (method_exists($img, 'temporaryUrl'))
                        <img src="{{ $img->temporaryUrl() }}" alt="" class="w-full h-24 object-cover" />
                    @endif
                    <span class="absolute top-1 left-1 bg-amber-500 text-white text-[10px] px-1.5 py-0.5 rounded">Baru</span>
                    <button type="button" wire:click="removeNewImage({{ $i }})"
                            class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-red-300 text-lg">✕</button>
                </div>
            @endforeach
        </div>
    @endif

    <div>
        <input type="file" wire:model="newImages" multiple accept="image/*"
               class="block w-full text-sm text-forest-200/70 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-forest-600 file:text-white file:font-semibold hover:file:bg-forest-500 cursor-pointer" />
        <div wire:loading wire:target="newImages" class="text-forest-300 text-xs mt-2">Mengunggah…</div>
        @error('newImages') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
        @error('newImages.*') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
        <p class="text-forest-200/50 text-xs mt-2">
            Format JPG/PNG/WebP, maks. 12 MB per gambar. Setelah memilih, gambar muncul sebagai pratinjau
            <span class="text-amber-300">"Baru"</span> — klik tombol <strong>Simpan</strong> di bawah agar tersimpan &amp; tampil di situs.
        </p>
    </div>
</div>
