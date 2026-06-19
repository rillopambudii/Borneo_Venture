@extends('layouts.app')

@section('title', 'Booking Trip')

@section('content')

{{-- HERO --}}
<section class="relative h-64 md:h-80 overflow-hidden flex items-end">
    <div class="absolute inset-0 bg-cover bg-center"
         style="background-image: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=1600')"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/40 to-forest-900"></div>
    <div class="relative z-10 max-w-6xl mx-auto px-6 pb-12 w-full">
        <p class="text-forest-300 text-sm font-medium tracking-widest uppercase mb-2">Mulai Petualanganmu</p>
        <h1 class="font-serif text-4xl md:text-5xl font-bold text-white">Booking Trip</h1>
    </div>
</section>

{{-- BOOKING FORM (Livewire) --}}
<livewire:booking-form />

@endsection
