@extends('layouts.app')

@section('title', 'Booking ' . $booking->booking_code)

@section('content')

<section class="min-h-screen pt-28 pb-20 px-6">
    <div class="max-w-3xl mx-auto">

        {{-- SUCCESS HEADER --}}
        <div class="text-center mb-10"
             x-data
             x-init="setTimeout(() => window.confetti && window.confetti({ particleCount: 160, spread: 85, origin: { y: 0.35 }, colors: ['#2e7d32','#81c784','#ffd479','#cfe3d4'] }), 250)">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-forest-500 rounded-full mb-6 animate-[popIn_0.5s_ease-out]">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="font-serif text-4xl md:text-5xl font-bold text-white mb-3">Booking Diterima!</h1>
            <p class="text-forest-200/80 text-lg">
                Terima kasih, <span class="text-white font-semibold">{{ $booking->name }}</span>. Tinggal satu langkah lagi untuk mengamankan kursimu.
            </p>
        </div>

        {{-- BOOKING CODE + STATUS --}}
        <div class="bg-forest-700 rounded-3xl p-6 md:p-8 mb-6" x-data="{ copied: false }">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <p class="text-forest-300 text-sm mb-1">Kode Booking</p>
                    <div class="flex items-center gap-3">
                        <span class="font-mono text-2xl md:text-3xl font-bold text-white tracking-widest">{{ $booking->booking_code }}</span>
                        <button @click="navigator.clipboard.writeText('{{ $booking->booking_code }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="text-forest-300 hover:text-white transition-colors"
                                title="Salin kode">
                            <svg x-show="!copied" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <svg x-show="copied" class="w-5 h-5 text-forest-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <span class="self-start sm:self-center px-4 py-2 rounded-full text-sm font-semibold border {{ $booking->status_classes }}">
                    {{ $booking->status_label }}
                </span>
            </div>
        </div>

        {{-- TRIP DETAIL --}}
        <div class="bg-forest-700 rounded-3xl overflow-hidden mb-6">
            <div class="flex flex-col sm:flex-row">
                <img src="{{ $booking->trip->image }}" alt="{{ $booking->trip->name }}"
                     class="w-full sm:w-48 h-40 sm:h-auto object-cover" />
                <div class="p-6 flex-1">
                    <h2 class="font-serif text-2xl font-bold text-white">{{ $booking->trip->name }}</h2>
                    <p class="text-forest-200/60 text-sm">{{ $booking->trip->location }}</p>
                    <div class="grid grid-cols-2 gap-4 mt-5 text-sm">
                        <div>
                            <p class="text-forest-300/70">Tanggal</p>
                            <p class="text-white font-medium">{{ $booking->trip_date->translatedFormat('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-forest-300/70">Durasi</p>
                            <p class="text-white font-medium">{{ $booking->trip->duration }}</p>
                        </div>
                        <div>
                            <p class="text-forest-300/70">Peserta</p>
                            <p class="text-white font-medium">{{ $booking->participants }} orang</p>
                        </div>
                        <div>
                            <p class="text-forest-300/70">Total</p>
                            <p class="text-forest-300 font-bold">{{ $booking->total_price_formatted }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PRIMARY ACTION: WHATSAPP CONFIRM --}}
        <div class="bg-gradient-to-br from-forest-600 to-forest-700 rounded-3xl p-6 md:p-8 mb-6 text-center border border-forest-500/40">
            <h3 class="font-serif text-2xl font-bold text-white mb-2">Konfirmasi Booking Kamu</h3>
            <p class="text-forest-200/80 text-sm mb-6 max-w-md mx-auto">
                Booking-mu masih <strong class="text-amber-300">menunggu konfirmasi</strong>. Klik tombol di bawah untuk chat tim BV — detail booking sudah otomatis terisi.
            </p>
            <a href="{{ $booking->whatsappConfirmUrl() }}" target="_blank" rel="noopener"
               class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-[#25D366] hover:bg-[#20bd5a] text-white font-bold rounded-2xl transition-all duration-300 hover:shadow-lg hover:shadow-green-500/30 text-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Konfirmasi via WhatsApp
            </a>
        </div>

        {{-- WHAT'S NEXT --}}
        <div class="bg-forest-700/60 rounded-3xl p-6 md:p-8 mb-6">
            <h3 class="font-semibold text-white mb-5">Apa selanjutnya?</h3>
            <div class="space-y-4">
                @foreach([
                    ['Konfirmasi via WhatsApp', 'Klik tombol di atas, kirim pesannya ke tim BV.'],
                    ['Tim BV membalas', 'Kami cek ketersediaan & konfirmasi detail trip-mu.'],
                    ['Pembayaran', 'Info pembayaran dikirim via WhatsApp setelah dikonfirmasi.'],
                    ['Berpetualang! 🌿', 'Kursimu aman — tinggal siapin diri untuk eksplorasi.'],
                ] as $i => $step)
                <div class="flex gap-4">
                    <span class="flex-shrink-0 w-7 h-7 rounded-full bg-forest-500 text-white text-sm font-bold flex items-center justify-center">{{ $i + 1 }}</span>
                    <div>
                        <p class="text-white font-medium text-sm">{{ $step[0] }}</p>
                        <p class="text-forest-200/60 text-sm">{{ $step[1] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- SECONDARY ACTIONS --}}
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ $booking->googleCalendarUrl() }}" target="_blank" rel="noopener" class="btn-outline text-center text-sm">
                📅 Tambah ke Google Calendar
            </a>
            <a href="{{ route('booking') }}" class="btn-outline text-center text-sm">Booking Trip Lain</a>
            <a href="{{ route('home') }}" class="btn-primary text-center text-sm">← Kembali ke Home</a>
        </div>

        <p class="text-center text-forest-200/40 text-xs mt-8">
            Simpan kode <span class="font-mono text-forest-200/60">{{ $booking->booking_code }}</span> untuk referensi. Butuh bantuan? Hubungi kami di Instagram <a href="https://instagram.com/{{ config('borneo.instagram') }}" target="_blank" class="text-forest-300 hover:underline">@{{ config('borneo.instagram') }}</a>.
        </p>
    </div>
</section>

@endsection

@push('scripts')
<style>
@keyframes popIn {
    0%   { transform: scale(0); opacity: 0; }
    60%  { transform: scale(1.15); }
    100% { transform: scale(1); opacity: 1; }
}
</style>
@endpush
