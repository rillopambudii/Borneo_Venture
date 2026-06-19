<div class="space-y-10">

    {{-- ADD FORM --}}
    <div class="bg-forest-800 border border-forest-600 rounded-2xl p-6">
        <h2 class="font-serif text-2xl font-bold text-white mb-4">Tambah Postingan</h2>

        @if (session('status'))
            <div class="bg-forest-500/20 border border-forest-400/40 text-forest-100 text-sm rounded-xl px-4 py-3 mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="add" class="space-y-4">
            <div>
                <label class="block text-forest-200/80 text-sm mb-2">URL Postingan / Reel Instagram</label>
                <input type="text" wire:model="instagram_url" class="input-field"
                       placeholder="https://www.instagram.com/p/XXXXXXXXX/" />
                @error('instagram_url') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-forest-200/80 text-sm mb-2">Caption (opsional)</label>
                <input type="text" wire:model="caption" class="input-field" placeholder="Sungai Kayan, Kalimantan Utara" />
                @error('caption') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="btn-primary">
                <span wire:loading.remove wire:target="add">Tambahkan</span>
                <span wire:loading wire:target="add">Menyimpan…</span>
            </button>
        </form>

        <p class="text-forest-200/50 text-xs mt-4">
            Tip: buka postingan di Instagram, klik <strong>⋯ &rarr; Salin tautan</strong>, lalu tempel di sini.
        </p>
    </div>

    {{-- LIST --}}
    <div>
        <h2 class="font-serif text-2xl font-bold text-white mb-4">
            Postingan di Galeri ({{ $items->count() }})
        </h2>

        @if ($items->isEmpty())
            <p class="text-forest-200/60">Belum ada postingan. Tambahkan lewat form di atas.</p>
        @else
            <div class="space-y-3">
                @foreach ($items as $item)
                    <div class="flex items-center gap-4 bg-forest-700 rounded-xl px-4 py-3" wire:key="item-{{ $item->id }}">
                        <div class="flex flex-col gap-1">
                            <button wire:click="moveUp({{ $item->id }})" title="Naikkan"
                                    class="text-forest-300 hover:text-white {{ $loop->first ? 'opacity-30 pointer-events-none' : '' }}">▲</button>
                            <button wire:click="moveDown({{ $item->id }})" title="Turunkan"
                                    class="text-forest-300 hover:text-white {{ $loop->last ? 'opacity-30 pointer-events-none' : '' }}">▼</button>
                        </div>

                        <div class="flex-1 min-w-0">
                            <a href="{{ $item->instagram_url }}" target="_blank" rel="noopener"
                               class="text-forest-200 hover:text-forest-300 text-sm truncate block">{{ $item->instagram_url }}</a>
                            @if ($item->caption)
                                <p class="text-forest-200/50 text-xs truncate">{{ $item->caption }}</p>
                            @endif
                        </div>

                        <button wire:click="toggle({{ $item->id }})"
                                class="text-xs font-semibold px-3 py-1 rounded-full {{ $item->is_active ? 'bg-forest-500 text-white' : 'bg-forest-900 text-forest-300' }}">
                            {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                        </button>

                        <button wire:click="delete({{ $item->id }})"
                                wire:confirm="Hapus postingan ini dari galeri?"
                                class="text-red-300 hover:text-red-200 text-sm font-semibold">Hapus</button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
