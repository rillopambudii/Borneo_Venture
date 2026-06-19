<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Borneo Venture') — Explore The Untouched</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-forest-900 text-forest-100 font-sans overflow-x-hidden">

    {{-- PAGE TRANSITION LOADER --}}
    @include('partials.page-loader')

    {{-- INTERACTIVE BACKGROUND --}}
    @include('partials.fireflies')

    {{-- NAVBAR (hidden in admin area — admin has its own nav) --}}
    @unless(request()->is('admin/*'))
    <nav x-data="{ open: false, scrolled: false }"
         @scroll.window="scrolled = window.scrollY > 60"
         :class="scrolled ? 'bg-black/80 backdrop-blur-md shadow-lg' : 'bg-transparent'"
         class="fixed top-0 left-0 w-full z-50 transition-all duration-500 px-6 md:px-10 py-4 flex justify-between items-center">

        <a href="{{ route('home') }}" class="font-serif text-xl font-bold text-white hover:text-forest-300 transition-colors">
            Borneo Venture
        </a>

        {{-- Desktop Nav --}}
        <ul class="hidden md:flex items-center gap-8 text-sm font-medium">
            <li><a href="{{ route('home') }}" class="text-white hover:text-forest-300 transition-colors {{ request()->routeIs('home') ? 'text-forest-300' : '' }}">Home</a></li>
            <li><a href="{{ route('home') }}#latar-belakang" class="text-white hover:text-forest-300 transition-colors">Tentang</a></li>
            <li><a href="{{ route('home') }}#explore" class="text-white hover:text-forest-300 transition-colors">Destinasi</a></li>
            <li><a href="{{ route('gallery') }}" class="text-white hover:text-forest-300 transition-colors {{ request()->routeIs('gallery') ? 'text-forest-300' : '' }}">Galeri</a></li>
            <li><a href="{{ route('booking') }}" class="text-white hover:text-forest-300 transition-colors {{ request()->routeIs('booking*') ? 'text-forest-300' : '' }}">Booking</a></li>
            <li><a href="{{ route('merchandise') }}" class="text-white hover:text-forest-300 transition-colors {{ request()->routeIs('merchandise') ? 'text-forest-300' : '' }}">Merchandise</a></li>
            <li><a href="{{ route('home') }}#contact" class="text-white hover:text-forest-300 transition-colors">Kontak</a></li>
            <li>
                <a href="{{ route('booking') }}" class="px-5 py-2 bg-forest-500 hover:bg-forest-400 text-white rounded-full text-sm font-semibold transition-all duration-300">
                    Booking Sekarang
                </a>
            </li>
        </ul>

        {{-- Mobile Hamburger --}}
        <button @click="open = !open" class="md:hidden text-white focus:outline-none">
            <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Mobile Menu --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden absolute top-full left-0 w-full bg-black/95 backdrop-blur-md py-6 px-6 flex flex-col gap-4 text-sm font-medium border-t border-forest-700">
            <a href="{{ route('home') }}" @click="open=false" class="text-white hover:text-forest-300">Home</a>
            <a href="{{ route('home') }}#latar-belakang" @click="open=false" class="text-white hover:text-forest-300">Tentang</a>
            <a href="{{ route('home') }}#explore" @click="open=false" class="text-white hover:text-forest-300">Destinasi</a>
            <a href="{{ route('gallery') }}" @click="open=false" class="text-white hover:text-forest-300">Galeri</a>
            <a href="{{ route('booking') }}" @click="open=false" class="text-white hover:text-forest-300">Booking</a>
            <a href="{{ route('merchandise') }}" @click="open=false" class="text-white hover:text-forest-300">Merchandise</a>
            <a href="{{ route('home') }}#contact" @click="open=false" class="text-white hover:text-forest-300">Kontak</a>
            <a href="{{ route('booking') }}" class="btn-primary text-center mt-2">Booking Sekarang</a>
        </div>
    </nav>
    @endunless

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-forest-950 border-t border-forest-800 py-12 px-6">
        <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8">
            <div>
                <h3 class="font-serif text-xl font-bold text-white mb-3">Borneo Venture</h3>
                <p class="text-forest-200/70 text-sm leading-relaxed">
                    Komunitas penjelajah Kalimantan Timur. Mengenalkan destinasi tersembunyi dan potensi lokal desa-desa.
                </p>
                <p class="text-forest-200/50 text-xs mt-3">Didirikan oleh Rojo Octa (Rizqi Nur Oktavianto) · 28 Agustus 2024</p>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-3">Navigasi</h4>
                <ul class="space-y-2 text-sm text-forest-200/70">
                    <li><a href="{{ route('home') }}" class="hover:text-forest-300 transition-colors">Home</a></li>
                    <li><a href="{{ route('gallery') }}" class="hover:text-forest-300 transition-colors">Galeri</a></li>
                    <li><a href="{{ route('booking') }}" class="hover:text-forest-300 transition-colors">Booking Trip</a></li>
                    <li><a href="{{ route('merchandise') }}" class="hover:text-forest-300 transition-colors">Merchandise</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-3">Kontak</h4>
                <ul class="space-y-2 text-sm text-forest-200/70">
                    <li>📸 @borneo.venture</li>
                    <li>📧 borneoventure@gmail.com</li>
                    <li>📍 Samarinda, Kalimantan Timur</li>
                </ul>
            </div>
        </div>
        <div class="max-w-6xl mx-auto mt-8 pt-6 border-t border-forest-800 text-center text-forest-200/40 text-xs">
            © {{ date('Y') }} Borneo Venture — Explore The Untouched
        </div>
    </footer>

    @livewireScripts
    @stack('scripts')
</body>
</html>
