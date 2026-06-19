{{-- Shared admin sub-navigation. Pass $title (page heading). --}}
<div class="flex flex-col gap-6 mb-10">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <p class="text-forest-300 text-sm font-medium tracking-widest uppercase mb-1">Admin Panel</p>
            <h1 class="font-serif text-4xl font-bold text-white">{{ $title }}</h1>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" target="_blank" class="text-forest-300 hover:text-forest-200 text-sm">Lihat situs ↗</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn-outline text-sm py-2 px-5">Keluar</button>
            </form>
        </div>
    </div>

    <nav class="flex flex-wrap gap-2">
        @php
            $links = [
                ['route' => 'admin.gallery',   'label' => 'Galeri'],
                ['route' => 'admin.aspek',     'label' => 'Empat Aspek'],
                ['route' => 'admin.highlight', 'label' => 'Eksplorasi Borneo'],
                ['route' => 'admin.tentang',   'label' => 'Tentang Kami'],
            ];
        @endphp
        @foreach ($links as $link)
            @php $active = request()->routeIs($link['route']); @endphp
            <a href="{{ route($link['route']) }}"
               class="px-4 py-2 rounded-full text-sm font-semibold transition-colors {{ $active ? 'bg-forest-500 text-white' : 'bg-forest-800 text-forest-200 hover:bg-forest-700' }}">
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>
</div>
