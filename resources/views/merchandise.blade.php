@extends('layouts.app')

@section('title', 'Merchandise')

@section('content')

{{-- HERO --}}
<section class="relative h-64 md:h-80 overflow-hidden flex items-end">
    <div class="absolute inset-0 bg-cover bg-center"
         style="background-image: url('https://images.unsplash.com/photo-1520975922323-7c8c3bafc92d?w=1600')"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/40 to-forest-900"></div>
    <div class="relative z-10 max-w-6xl mx-auto px-6 pb-12 w-full">
        <p class="text-forest-300 text-sm font-medium tracking-widest uppercase mb-2">Kenakan Identitas Petualangmu</p>
        <h1 class="font-serif text-4xl md:text-5xl font-bold text-white">Official Merchandise</h1>
    </div>
</section>

{{-- MERCHANDISE CART (Livewire) --}}
<section class="max-w-6xl mx-auto px-6 py-12">
    <livewire:merchandise-cart />
</section>

{{-- STORY --}}
<section class="bg-forest-800 py-16 px-6">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="font-serif text-3xl font-bold text-white mb-4">Lebih dari Sekadar Merchandise</h2>
        <p class="text-forest-200/70 leading-relaxed text-lg">
            Setiap produk Borneo Venture dibuat untuk menemani perjalananmu. Dari hutan Kalimantan hingga petualanganmu berikutnya, ini bukan hanya pakaian — ini adalah identitas petualang.
        </p>
    </div>
</section>

@endsection
