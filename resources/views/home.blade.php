@extends('layouts.app')

@section('title', 'Borneo Venture')

@section('content')

{{-- HERO --}}
<section class="relative h-screen w-full overflow-hidden" x-data="hero()">
    <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
        <source src="https://cdn.coverr.co/videos/coverr-aerial-view-of-a-forest-5176/1080p.mp4" type="video/mp4" />
    </video>
    <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/30 to-forest-900"></div>

    {{-- Fog effect --}}
    <div class="absolute inset-0 opacity-10 bg-repeat animate-[fogMove_60s_linear_infinite]"
         style="background-image: url('https://www.transparenttextures.com/patterns/fog.png'); background-size: 300px;"></div>

    <div class="relative z-10 h-full flex flex-col justify-center items-center text-center px-6">
        <p class="text-forest-300 text-sm font-medium tracking-widest uppercase mb-4 opacity-0 animate-[fadeInUp_0.8s_0.2s_forwards]">
            Kalimantan Timur, Indonesia
        </p>
        <h1 class="font-serif text-5xl md:text-7xl font-bold text-white max-w-4xl leading-tight mb-6
                   opacity-0 animate-[fadeInUp_0.8s_0.4s_forwards]">
            Berpetualang bareng BV di Alam Liar Kalimantan
        </h1>
        <p class="text-forest-200/80 max-w-2xl text-lg mb-10 leading-relaxed
                  opacity-0 animate-[fadeInUp_0.8s_0.6s_forwards]">
            Komunitas penjelajah asal Kalimantan Timur yang membuka akses ke wisata desa tersembunyi — memadukan alam, budaya, sosial, dan kearifan lokal. Didirikan oleh Rojo Octa sejak 2024.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 opacity-0 animate-[fadeInUp_0.8s_0.8s_forwards]">
            <a href="{{ route('booking') }}" class="btn-primary text-base px-8 py-4">
                Mulai Ekspedisi
            </a>
            <a href="#explore" class="btn-outline text-base px-8 py-4">
                Lihat Destinasi
            </a>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-bounce opacity-60">
        <span class="text-xs text-white tracking-widest uppercase">Scroll</span>
        <div class="w-px h-12 bg-gradient-to-b from-white to-transparent"></div>
    </div>
</section>

{{-- STATS --}}
<section class="bg-forest-800/90 backdrop-blur-sm py-12 px-6 relative">
    <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        @foreach([
            ['value' => 2000, 'suffix' => '+', 'label' => 'Penjelajah', 'sub' => 'Dalam 9 bulan pertama'],
            ['value' => 30,   'suffix' => '+', 'label' => 'Desa',       'sub' => 'Telah disurvei'],
            ['value' => 6700, 'suffix' => '+', 'label' => 'Followers',  'sub' => '@borneo.venture'],
            ['value' => 4,    'suffix' => 'x', 'label' => 'Trip/Bulan', 'sub' => 'Rutin & konsisten'],
        ] as $stat)
        <div x-data="counter({{ $stat['value'] }})" x-intersect.once="start()">
            <div class="font-serif text-4xl font-bold text-forest-300">
                <span x-text="format(display)">{{ number_format($stat['value']) }}</span>{{ $stat['suffix'] }}
            </div>
            <div class="text-white font-semibold mt-1">{{ $stat['label'] }}</div>
            <div class="text-forest-200/60 text-sm">{{ $stat['sub'] }}</div>
        </div>
        @endforeach
    </div>
</section>

{{-- STORY / TENTANG KAMI --}}
@if($about)
<section id="story" class="max-w-6xl mx-auto px-6 py-24">
    <div class="grid md:grid-cols-2 gap-16 items-center">
        <div class="relative group">
            @include('partials.image-carousel', [
                'images' => $about->image_urls,
                'heightClass' => 'h-[480px]',
                'roundedClass' => 'rounded-3xl',
            ])
            @if($about->badge_title)
            <div class="absolute -bottom-6 -right-6 bg-forest-500 text-white p-6 rounded-2xl shadow-2xl">
                <div class="font-serif text-3xl font-bold">{{ $about->badge_title }}</div>
                @if($about->badge_subtitle)
                <div class="text-sm opacity-80">{{ $about->badge_subtitle }}</div>
                @endif
            </div>
            @endif
        </div>
        <div>
            <p class="text-forest-300 text-sm font-medium tracking-widest uppercase mb-4">{{ $about->eyebrow }}</p>
            <h2 class="font-serif text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
                {{ $about->title }}
            </h2>
            @foreach($about->paragraphs as $paragraph)
            <p class="text-forest-200/80 leading-relaxed mb-6">{!! nl2br(e($paragraph)) !!}</p>
            @endforeach
            @if(!empty($about->tags))
            <div class="flex flex-wrap gap-3 mt-2">
                @foreach($about->tags as $tag)
                <span class="px-4 py-1.5 bg-forest-600 text-forest-300 rounded-full text-sm font-medium">{{ $tag }}</span>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- PARALLAX --}}
<section class="relative h-[60vh] overflow-hidden flex items-center justify-center"
         style="background: url('https://images.unsplash.com/photo-1502082553048-f009c37129b9?w=1600') center/cover fixed;">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative z-10 text-center px-6">
        <h2 class="font-serif text-5xl md:text-6xl font-bold text-white mb-4">Alam Tidak Pernah Berbohong</h2>
        <p class="text-white/80 text-xl max-w-2xl mx-auto">
            Setiap perjalanan adalah cerita. Setiap destinasi adalah kejutan. Bersama BV, jelajahi yang tersembunyi.
        </p>
    </div>
</section>

{{-- 4 ASPEK EKSPLORASI (interactive) --}}
@if($aspects->isNotEmpty())
<section id="aspek" class="max-w-6xl mx-auto px-6 py-24"
         x-data="{ active: 0, imgIndex: 0, aspects: @js($aspectsData) }"
         x-init="$watch('active', () => imgIndex = 0)">
    <div class="text-center mb-16">
        <p class="text-forest-300 text-sm font-medium tracking-widest uppercase mb-4">Cara Kami Menjelajah</p>
        <h2 class="section-title">Empat Aspek Eksplorasi</h2>
        <p class="text-forest-200/60 max-w-2xl mx-auto mt-4">Setiap trip Borneo Venture memadukan beberapa dimensi yang membuat perjalanan jauh lebih bermakna.</p>
    </div>

    <div class="grid lg:grid-cols-2 gap-10 items-center">
        {{-- Selector --}}
        <div class="space-y-3">
            <template x-for="(a, i) in aspects" :key="i">
                <button @click="active = i"
                        :class="active === i ? 'bg-forest-600 border-forest-300 shadow-lg' : 'bg-forest-700/60 border-forest-700 hover:border-forest-500'"
                        class="w-full text-left p-5 rounded-2xl border transition-all duration-300 flex items-start gap-4">
                    <span class="text-3xl" x-text="a.icon"></span>
                    <div>
                        <h3 class="font-serif text-xl font-bold text-white" x-text="a.title"></h3>
                        <p class="text-forest-200/70 text-sm mt-1 leading-relaxed transition-all duration-300"
                           :class="active === i ? 'opacity-100 max-h-32' : 'opacity-60 max-h-12 overflow-hidden'"
                           x-text="a.desc"></p>
                    </div>
                </button>
            </template>
        </div>

        {{-- Image preview (carousel) --}}
        <div class="relative h-[420px] rounded-3xl overflow-hidden group">
            <template x-for="(img, i) in aspects[active].images" :key="i">
                <img :src="img" :alt="aspects[active].title"
                     x-show="imgIndex === i"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 scale-105"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="absolute inset-0 w-full h-full object-cover" />
            </template>

            <div x-show="!aspects[active].images.length"
                 class="absolute inset-0 bg-forest-700 flex items-center justify-center text-forest-300 text-sm">
                Belum ada gambar
            </div>

            <div class="absolute inset-0 bg-gradient-to-t from-forest-900/80 to-transparent pointer-events-none"></div>
            <div class="absolute bottom-6 left-6 pointer-events-none">
                <span class="text-5xl" x-text="aspects[active].icon"></span>
                <h3 class="font-serif text-2xl font-bold text-white mt-2" x-text="aspects[active].title"></h3>
            </div>

            {{-- Next / Prev --}}
            <template x-if="aspects[active].images.length > 1">
                <div>
                    <button @click="imgIndex = (imgIndex - 1 + aspects[active].images.length) % aspects[active].images.length"
                            aria-label="Sebelumnya"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 hover:bg-black/70 text-white text-2xl flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity z-10">‹</button>
                    <button @click="imgIndex = (imgIndex + 1) % aspects[active].images.length"
                            aria-label="Berikutnya"
                            class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 hover:bg-black/70 text-white text-2xl flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity z-10">›</button>
                    <div class="absolute top-3 right-3 bg-black/50 text-white text-xs px-2 py-0.5 rounded-full z-10">
                        <span x-text="imgIndex + 1"></span>/<span x-text="aspects[active].images.length"></span>
                    </div>
                </div>
            </template>
        </div>
    </div>
</section>
@endif

{{-- LATAR BELAKANG / SANG PENDIRI --}}
<section id="latar-belakang" class="bg-forest-800/90 backdrop-blur-sm py-24 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <p class="text-forest-300 text-sm font-medium tracking-widest uppercase mb-4">Latar Belakang</p>
            <h2 class="section-title">Sang Penjelajah Rimba</h2>
        </div>

        <div class="grid lg:grid-cols-5 gap-12 items-center">
            {{-- Founder card --}}
            <div class="lg:col-span-2">
                <div class="bg-forest-700 border border-forest-600 rounded-3xl p-8 text-center shadow-lg shadow-black/30">
                    <img src="{{ asset('images/founder-rojo.jpg') }}"
                         alt="Rizqi Nur Oktavianto - Founder Borneo Venture"
                         class="w-28 h-28 mx-auto rounded-full object-cover mb-4" />
                    <h3 class="font-serif text-2xl font-bold text-white">Rizqi Nur Oktavianto</h3>
                    <p class="text-forest-300 text-sm">"Rojo Octa" · Founder</p>
                    <p class="text-forest-200/60 text-sm mt-4 leading-relaxed">
                        Lulusan Fakultas Kehutanan Universitas Mulawarman dengan fokus pemetaan. Surveyor hutan, kreator video, dan penjelajah sejati Kalimantan.
                    </p>
                    <div class="flex justify-center gap-2 mt-5 flex-wrap">
                        <span class="px-3 py-1 bg-forest-600 text-forest-300 rounded-full text-xs font-medium">Forestry Unmul</span>
                        <span class="px-3 py-1 bg-forest-600 text-forest-300 rounded-full text-xs font-medium">Forest Surveyor</span>
                        <span class="px-3 py-1 bg-forest-600 text-forest-300 rounded-full text-xs font-medium">Video Creator</span>
                    </div>
                </div>
            </div>

            {{-- Timeline --}}
            <div class="lg:col-span-3">
                <div class="space-y-6">
                    @foreach([
                        ['Akar di Samarinda', 'Lahir dan besar di Samarinda, lulus dari MAN 2 Samarinda sebelum menekuni ilmu kehutanan.'],
                        ['Ilmu & Pengalaman', 'Kuliah di Fakultas Kehutanan Universitas Mulawarman, fokus pemetaan. Pernah riset di KMUTT, Thailand (Provinsi Nan) — membuka wawasan soal potensi wisata & keberagaman budaya.'],
                        ['Surveyor Hutan', 'Karier sebagai surveyor pemetaan hutan membawanya keluar-masuk rimba Kalimantan — pengalaman lapangan yang jadi fondasi Borneo Venture.'],
                        ['Lahirnya Borneo Venture', 'Pada 28 Agustus 2024, hobi menjelajah ini berkembang jadi komunitas. Batch pertama langsung diikuti 30+ peserta, dan terus tumbuh hingga kini.'],
                    ] as $i => $item)
                    <div class="relative pl-10" x-data="{ shown: false }" x-intersect.once="shown = true">
                        <div class="absolute left-0 top-1 w-6 h-6 rounded-full bg-forest-500 border-4 border-forest-800 transition-all duration-500"
                             :class="shown ? 'scale-100' : 'scale-0'"></div>
                        @if(!$loop->last)
                        <div class="absolute left-[11px] top-7 w-0.5 h-full bg-forest-600"></div>
                        @endif
                        <div class="transition-all duration-700"
                             :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-4'">
                            <h4 class="font-semibold text-white text-lg">{{ $item[0] }}</h4>
                            <p class="text-forest-200/70 text-sm mt-1 leading-relaxed">{{ $item[1] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- EKSPLORASI BORNEO (highlight showcase) --}}
@if($highlights->isNotEmpty())
<section id="explore" class="max-w-6xl mx-auto px-6 py-24">
    <div class="text-center mb-16">
        <p class="text-forest-300 text-sm font-medium tracking-widest uppercase mb-4">Destinasi Pilihan</p>
        <h2 class="section-title">Eksplorasi Borneo</h2>
        <p class="text-forest-200/60 max-w-2xl mx-auto mt-4">Jejak nyata Borneo Venture di pelosok Kalimantan Timur — geser galeri tiap destinasi untuk melihat lebih banyak.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        @foreach($highlights as $highlight)
        <div class="card-dark group" wire:key="hl-{{ $highlight->id }}">
            <div class="relative overflow-hidden">
                @include('partials.image-carousel', [
                    'images' => $highlight->image_urls,
                    'heightClass' => 'h-56',
                ])
                <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/70 to-transparent pointer-events-none"></div>
                @if($highlight->location)
                <div class="absolute bottom-3 left-3 right-3 pointer-events-none">
                    <p class="text-forest-200/90 text-sm font-medium">📍 {{ $highlight->location }}</p>
                </div>
                @endif
            </div>
            <div class="p-5">
                <h3 class="font-serif text-xl font-bold text-white mb-2">{{ $highlight->title }}</h3>
                <p class="text-forest-200/70 text-sm leading-relaxed line-clamp-3">{{ $highlight->description }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-10">
        <a href="{{ route('booking') }}" class="btn-outline inline-block">
            Ikut Trip Berikutnya →
        </a>
    </div>
</section>
@endif

{{-- TESTIMONIAL --}}
<section class="bg-forest-800 py-20 px-6">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
            <p class="text-forest-300 text-sm font-medium tracking-widest uppercase mb-4">Kata Mereka</p>
            <h2 class="section-title">Cerita Para Explorer</h2>
        </div>

        <div x-data="testimonials()" class="relative">
            <div class="overflow-hidden">
                <div class="flex transition-transform duration-500 ease-in-out"
                     :style="`transform: translateX(-${current * 100}%)`">
                    @foreach([
                        ['Ahmad Rizky', 'Trip ke Desa Bhuana Jaya luar biasa! Guide-nya sangat profesional dan alam Kalimantannya benar-benar memukau. Pasti balik lagi!', '⭐⭐⭐⭐⭐', 'Samarinda'],
                        ['Siti Rahayu', 'Pengalaman camping di Bukit Mahoni adalah yang terbaik dalam hidup saya. Milky Way-nya jelas banget, dan tim BV sangat care sama safety.', '⭐⭐⭐⭐⭐', 'Jakarta'],
                        ['Doni Pratama', 'Cave tubing di Goa Batu Gelap seru banget! Worth every penny. Dokumentasinya juga keren, foto-foto hasilnya bagus semua.', '⭐⭐⭐⭐⭐', 'Balikpapan'],
                    ] as $i => $review)
                    <div class="min-w-full px-4">
                        <div class="bg-forest-700 border border-forest-600 rounded-3xl p-8 md:p-12 text-center max-w-3xl mx-auto shadow-lg shadow-black/30">
                            <p class="text-2xl mb-2">{{ $review[2] }}</p>
                            <p class="text-forest-200/90 text-xl leading-relaxed italic mb-6">"{{ $review[1] }}"</p>
                            <p class="text-white font-semibold">{{ $review[0] }}</p>
                            <p class="text-forest-200/50 text-sm">{{ $review[3] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Controls --}}
            <div class="flex justify-center gap-3 mt-8">
                @for($i = 0; $i < 3; $i++)
                <button @click="current = {{ $i }}"
                        :class="current === {{ $i }} ? 'bg-forest-300 w-8' : 'bg-forest-600 w-3'"
                        class="h-3 rounded-full transition-all duration-300"></button>
                @endfor
            </div>
        </div>
    </div>
</section>

{{-- CTA / CONTACT --}}
<section id="contact" class="py-24 px-6">
    <div class="max-w-4xl mx-auto text-center">
        <p class="text-forest-300 text-sm font-medium tracking-widest uppercase mb-4">Siap Berpetualang?</p>
        <h2 class="section-title mb-6">Mulai Perjalananmu Sekarang</h2>
        <p class="text-forest-200/70 text-lg mb-10 max-w-2xl mx-auto">
            Hubungi kami atau langsung booking trip pilihanmu. Tim BV siap menemanimu menjelajahi keajaiban Kalimantan.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
            <a href="{{ route('booking') }}" class="btn-primary text-base px-10 py-4">
                Book Trip Sekarang
            </a>
            <a href="https://wa.me/628" target="_blank" class="btn-outline text-base px-10 py-4">
                WhatsApp Kami
            </a>
        </div>
        <div class="flex flex-col sm:flex-row justify-center gap-8 text-sm text-forest-200/60">
            <span>📸 @borneo.venture</span>
            <span>📧 borneoventure@gmail.com</span>
            <span>📍 Samarinda, Kalimantan Timur</span>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function hero() {
    return {}
}
function counter(target) {
    return {
        display: 0,
        target: target,
        format(n) {
            return Math.round(n).toLocaleString('id-ID');
        },
        start() {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                this.display = this.target;
                return;
            }
            const duration = 2000;
            const step = target / (duration / 16);
            const timer = setInterval(() => {
                this.display = Math.min(Math.round(this.display + step), this.target);
                if (this.display >= this.target) clearInterval(timer);
            }, 16);
        }
    }
}
function testimonials() {
    return {
        current: 0,
        init() {
            setInterval(() => { this.current = (this.current + 1) % 3; }, 5000);
        }
    }
}
function imageCarousel(count) {
    return {
        current: 0,
        count: count,
        next() { this.current = (this.current + 1) % this.count; },
        prev() { this.current = (this.current - 1 + this.count) % this.count; },
    }
}
</script>
<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fogMove {
    from { background-position: 0 0; }
    to   { background-position: 300px 0; }
}
</style>
@endpush
