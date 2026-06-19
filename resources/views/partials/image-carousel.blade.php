{{-- Reusable image carousel with next/prev buttons.
     Vars: $images (array<string> urls), $heightClass (default 'h-56'),
           $roundedClass (default ''). Relies on imageCarousel() Alpine fn. --}}
@php
    $heightClass = $heightClass ?? 'h-56';
    $roundedClass = $roundedClass ?? '';
@endphp

@if (empty($images))
    <div class="{{ $heightClass }} {{ $roundedClass }} w-full bg-forest-700 flex items-center justify-center text-forest-300 text-sm">
        Belum ada gambar
    </div>
@else
    <div x-data="imageCarousel({{ count($images) }})"
         class="relative {{ $heightClass }} {{ $roundedClass }} w-full overflow-hidden group">
        @foreach ($images as $i => $img)
            <img src="{{ $img }}" alt=""
                 x-show="current === {{ $i }}"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="absolute inset-0 w-full h-full object-cover" />
        @endforeach

        @if (count($images) > 1)
            {{-- Next / Prev --}}
            <button @click.prevent="prev()" aria-label="Sebelumnya"
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/40 hover:bg-black/70 text-white text-xl flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity z-10">‹</button>
            <button @click.prevent="next()" aria-label="Berikutnya"
                    class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/40 hover:bg-black/70 text-white text-xl flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity z-10">›</button>

            {{-- Dots --}}
            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5 z-10">
                @foreach ($images as $i => $img)
                    <button @click.prevent="current = {{ $i }}"
                            :class="current === {{ $i }} ? 'bg-white w-5' : 'bg-white/50 w-2'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                @endforeach
            </div>

            {{-- Counter --}}
            <div class="absolute top-3 right-3 bg-black/50 text-white text-xs px-2 py-0.5 rounded-full z-10">
                <span x-text="current + 1"></span>/{{ count($images) }}
            </div>
        @endif
    </div>
@endif
