@extends('layouts.app')

@section('title', 'Galeri')

@section('content')

{{-- HERO --}}
<section class="relative h-64 md:h-80 overflow-hidden flex items-end">
    <div class="absolute inset-0 bg-cover bg-center"
         style="background-image: url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=1600')"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/40 to-forest-900"></div>
    <div class="relative z-10 max-w-6xl mx-auto px-6 pb-12 w-full">
        <p class="text-forest-300 text-sm font-medium tracking-widest uppercase mb-2">Momen dari Lapangan</p>
        <h1 class="font-serif text-4xl md:text-5xl font-bold text-white">Galeri Petualangan</h1>
    </div>
</section>

{{-- GALLERY GRID --}}
<section class="max-w-6xl mx-auto px-6 py-16">
    @if ($items->isEmpty())
        <div class="text-center py-20">
            <p class="text-forest-200/70 text-lg">Galeri akan segera hadir. Pantau Instagram kami
                <a href="https://instagram.com/borneo.venture" target="_blank" rel="noopener"
                   class="text-forest-300 hover:text-forest-200 underline">@borneo.venture</a>.
            </p>
        </div>
    @else
        <div class="text-center mb-12">
            <h2 class="section-title">Jejak Kami di Instagram</h2>
            <p class="text-forest-200/70 mt-4 max-w-2xl mx-auto">
                Cuplikan perjalanan, destinasi tersembunyi, dan cerita dari komunitas Borneo Venture.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 items-start">
            @foreach ($items as $item)
                <div class="bg-forest-700 rounded-2xl overflow-hidden p-2 shadow-lg">
                    <blockquote class="instagram-media"
                                data-instgrm-permalink="{{ $item->embed_permalink }}"
                                data-instgrm-version="14"
                                style="background:#FFF; border:0; margin:0; padding:0; width:100%;"></blockquote>
                    @if ($item->caption)
                        <p class="text-forest-200/80 text-sm px-3 py-3">{{ $item->caption }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="text-center mt-14">
            <a href="https://instagram.com/borneo.venture" target="_blank" rel="noopener" class="btn-outline inline-block">
                Lihat Selengkapnya di Instagram
            </a>
        </div>
    @endif
</section>

@push('scripts')
    <script async src="//www.instagram.com/embed.js"></script>
    <script>
        // Re-process embeds once the script (or Livewire navigation) has loaded.
        document.addEventListener('DOMContentLoaded', function () {
            if (window.instgrm) {
                window.instgrm.Embeds.process();
            }
        });
    </script>
@endpush

@endsection
