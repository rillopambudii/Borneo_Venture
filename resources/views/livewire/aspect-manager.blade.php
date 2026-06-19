<div class="space-y-10">

    {{-- FORM --}}
    <div class="bg-forest-800 border border-forest-600 rounded-2xl p-6">
        <h2 class="font-serif text-2xl font-bold text-white mb-4">
            {{ $editingId ? 'Edit Aspek' : 'Tambah Aspek' }}
        </h2>

        @if (session('status'))
            <div class="bg-forest-500/20 border border-forest-400/40 text-forest-100 text-sm rounded-xl px-4 py-3 mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="save" class="space-y-4">
            <div class="grid sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-forest-200/80 text-sm mb-2">Ikon (emoji)</label>
                    <input type="text" wire:model="icon" class="input-field text-center text-2xl" maxlength="8" />
                    @error('icon') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-forest-200/80 text-sm mb-2">Judul</label>
                    <input type="text" wire:model="title" class="input-field" placeholder="Eksplorasi Alam" />
                    @error('title') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-forest-200/80 text-sm mb-2">Deskripsi</label>
                <textarea wire:model="description" rows="3" class="input-field" placeholder="Air terjun tersembunyi, bukit hijau…"></textarea>
                @error('description') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            @include('partials.admin.image-fields', ['existing' => $editingImages])

            <label class="flex items-center gap-2 text-forest-200/80 text-sm">
                <input type="checkbox" wire:model="is_active" class="rounded border-forest-500 text-forest-500 focus:ring-forest-400" />
                Tampilkan di halaman utama
            </label>

            <div class="flex items-center gap-3">
                <button type="submit" class="btn-primary">
                    <span wire:loading.remove wire:target="save">{{ $editingId ? 'Simpan Perubahan' : 'Tambahkan' }}</span>
                    <span wire:loading wire:target="save">Menyimpan…</span>
                </button>
                @if ($editingId)
                    <button type="button" wire:click="resetForm" class="btn-outline text-sm py-2 px-5">Batal</button>
                @endif
            </div>
        </form>
    </div>

    {{-- LIST --}}
    <div>
        <h2 class="font-serif text-2xl font-bold text-white mb-4">Daftar Aspek ({{ $aspects->count() }})</h2>

        @if ($aspects->isEmpty())
            <p class="text-forest-200/60">Belum ada aspek. Tambahkan lewat form di atas.</p>
        @else
            <div class="space-y-3">
                @foreach ($aspects as $aspect)
                    <div class="flex items-center gap-4 bg-forest-700 rounded-xl px-4 py-3" wire:key="aspect-{{ $aspect->id }}">
                        <div class="flex flex-col gap-1">
                            <button wire:click="moveUp({{ $aspect->id }})" class="text-forest-300 hover:text-white {{ $loop->first ? 'opacity-30 pointer-events-none' : '' }}">▲</button>
                            <button wire:click="moveDown({{ $aspect->id }})" class="text-forest-300 hover:text-white {{ $loop->last ? 'opacity-30 pointer-events-none' : '' }}">▼</button>
                        </div>

                        <div class="text-3xl">{{ $aspect->icon }}</div>

                        @if ($aspect->images->isNotEmpty())
                            <img src="{{ $aspect->images->first()->url }}" alt="" class="w-16 h-12 object-cover rounded-lg" />
                        @else
                            <div class="w-16 h-12 rounded-lg bg-forest-900 flex items-center justify-center text-forest-400 text-xs">—</div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <p class="text-white font-semibold truncate">{{ $aspect->title }}</p>
                            <p class="text-forest-200/50 text-xs truncate">{{ $aspect->description }}</p>
                            <p class="text-forest-300/70 text-[11px] mt-0.5">{{ $aspect->images->count() }} gambar</p>
                        </div>

                        <button wire:click="toggle({{ $aspect->id }})"
                                class="text-xs font-semibold px-3 py-1 rounded-full {{ $aspect->is_active ? 'bg-forest-500 text-white' : 'bg-forest-900 text-forest-300' }}">
                            {{ $aspect->is_active ? 'Aktif' : 'Nonaktif' }}
                        </button>
                        <button wire:click="edit({{ $aspect->id }})" class="text-forest-300 hover:text-white text-sm font-semibold">Edit</button>
                        <button wire:click="delete({{ $aspect->id }})" wire:confirm="Hapus aspek ini beserta gambarnya?"
                                class="text-red-300 hover:text-red-200 text-sm font-semibold">Hapus</button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
