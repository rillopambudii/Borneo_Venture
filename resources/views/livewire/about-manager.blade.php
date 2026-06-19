<div class="bg-forest-800 border border-forest-600 rounded-2xl p-6">
    @if (session('status'))
        <div class="bg-forest-500/20 border border-forest-400/40 text-forest-100 text-sm rounded-xl px-4 py-3 mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-4">
        <div>
            <label class="block text-forest-200/80 text-sm mb-2">Label kecil (eyebrow)</label>
            <input type="text" wire:model="eyebrow" class="input-field" placeholder="Tentang Kami" />
            @error('eyebrow') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-forest-200/80 text-sm mb-2">Judul</label>
            <input type="text" wire:model="title" class="input-field" placeholder="Dari Samarinda ke Pedalaman Kalimantan" />
            @error('title') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-forest-200/80 text-sm mb-2">Isi <span class="text-forest-200/40">(pisahkan paragraf dengan baris kosong)</span></label>
            <textarea wire:model="body" rows="6" class="input-field" placeholder="Paragraf pertama…&#10;&#10;Paragraf kedua…"></textarea>
            @error('body') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-forest-200/80 text-sm mb-2">Badge judul (opsional)</label>
                <input type="text" wire:model="badge_title" class="input-field" placeholder="2024" />
                @error('badge_title') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-forest-200/80 text-sm mb-2">Badge subjudul (opsional)</label>
                <input type="text" wire:model="badge_subtitle" class="input-field" placeholder="Berdiri 28 Agustus" />
                @error('badge_subtitle') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-forest-200/80 text-sm mb-2">Tag <span class="text-forest-200/40">(pisahkan dengan koma)</span></label>
            <input type="text" wire:model="tags" class="input-field" placeholder="Trek Hutan, Susur Sungai, Budaya Dayak" />
            @error('tags') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        @include('partials.admin.image-fields', ['existing' => $images])

        <button type="submit" class="btn-primary">
            <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
            <span wire:loading wire:target="save">Menyimpan…</span>
        </button>
    </form>
</div>
