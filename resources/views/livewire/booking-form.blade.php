<div class="max-w-6xl mx-auto px-6 py-12">

    {{-- BOOKING FORM --}}
    <form wire:submit="submit" class="grid lg:grid-cols-3 gap-8">

        {{-- LEFT: Trip Selection + Form --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Step 1: Pilih Trip --}}
            <div class="bg-forest-700 rounded-3xl p-6 md:p-8">
                <h3 class="font-serif text-2xl font-bold text-white mb-6 flex items-center gap-3">
                    <span class="flex items-center justify-center w-8 h-8 bg-forest-500 rounded-full text-sm font-bold">1</span>
                    Pilih Trip
                </h3>

                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach($trips as $trip)
                    <label class="block cursor-pointer">
                        <input type="radio" wire:model.live="tripId" value="{{ $trip->id }}" class="sr-only peer" />
                        <div class="relative rounded-2xl overflow-hidden border-2 transition-all duration-300
                                    peer-checked:border-forest-300 peer-checked:shadow-lg peer-checked:shadow-forest-500/20
                                    border-forest-600 hover:border-forest-400">
                            <img src="{{ $trip->image }}" alt="{{ $trip->name }}" class="w-full h-32 object-cover" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent
                                        peer-checked:from-forest-900/80 transition-colors"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-3">
                                <p class="font-semibold text-white text-sm">{{ $trip->name }}</p>
                                <p class="text-forest-300 text-xs">{{ $trip->duration }} · {{ $trip->price_formatted }}</p>
                            </div>
                            <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition-opacity">
                                <div class="w-6 h-6 bg-forest-300 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-forest-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>

                @error('tripId')
                <p class="mt-3 text-red-400 text-sm flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Step 2: Detail Peserta --}}
            <div class="bg-forest-700 rounded-3xl p-6 md:p-8">
                <h3 class="font-serif text-2xl font-bold text-white mb-6 flex items-center gap-3">
                    <span class="flex items-center justify-center w-8 h-8 bg-forest-500 rounded-full text-sm font-bold">2</span>
                    Detail Peserta
                </h3>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-forest-200/80 text-sm mb-2 font-medium">Nama Lengkap</label>
                        <input wire:model.live="name" type="text" placeholder="Masukkan nama lengkap"
                               class="input-field @error('name') border-red-500 @enderror" />
                        @error('name') <p class="mt-1 text-red-400 text-xs">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-forest-200/80 text-sm mb-2 font-medium">Email</label>
                        <input wire:model.live="email" type="email" placeholder="email@contoh.com"
                               class="input-field @error('email') border-red-500 @enderror" />
                        @error('email') <p class="mt-1 text-red-400 text-xs">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-forest-200/80 text-sm mb-2 font-medium">Nomor WhatsApp</label>
                        <input wire:model.live="whatsapp" type="text" placeholder="08xx-xxxx-xxxx"
                               class="input-field @error('whatsapp') border-red-500 @enderror" />
                        @error('whatsapp') <p class="mt-1 text-red-400 text-xs">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-forest-200/80 text-sm mb-2 font-medium">Tanggal Trip</label>
                        <input wire:model.live="tripDate" type="date"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               class="input-field @error('tripDate') border-red-500 @enderror" />
                        @error('tripDate') <p class="mt-1 text-red-400 text-xs">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-forest-200/80 text-sm mb-2 font-medium">
                            Jumlah Peserta
                            @if($selectedTrip)
                            <span class="text-forest-300/60">(Maks. {{ $selectedTrip->max_participants }} orang)</span>
                            @endif
                        </label>
                        <div class="flex items-center gap-4">
                            <button type="button" wire:click="decrementParticipants"
                                    class="w-10 h-10 rounded-full bg-forest-600 hover:bg-forest-500 text-white font-bold text-xl flex items-center justify-center transition-colors">−</button>
                            <span class="text-2xl font-bold text-white w-12 text-center">{{ $participants }}</span>
                            <button type="button" wire:click="incrementParticipants"
                                    class="w-10 h-10 rounded-full bg-forest-600 hover:bg-forest-500 text-white font-bold text-xl flex items-center justify-center transition-colors">+</button>
                            <span class="text-forest-200/50 text-sm">peserta</span>
                        </div>
                        @error('participants') <p class="mt-1 text-red-400 text-xs">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-forest-200/80 text-sm mb-2 font-medium">Catatan (opsional)</label>
                        <textarea wire:model="notes" rows="3" placeholder="Alergi, permintaan khusus, dsb..."
                                  class="input-field resize-none"></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Summary --}}
        <div class="lg:col-span-1">
            <div class="bg-forest-700 rounded-3xl p-6 sticky top-24">
                <h3 class="font-serif text-xl font-bold text-white mb-6">Ringkasan Booking</h3>

                @if($selectedTrip)
                <div class="mb-6">
                    <img src="{{ $selectedTrip->image }}" alt="{{ $selectedTrip->name }}"
                         class="w-full h-36 object-cover rounded-xl mb-4" />
                    <h4 class="font-semibold text-white">{{ $selectedTrip->name }}</h4>
                    <p class="text-forest-200/60 text-sm">{{ $selectedTrip->location }}</p>
                    <p class="text-forest-300 text-sm mt-1">{{ $selectedTrip->duration }}</p>

                    @if($selectedTrip->includes)
                    <div class="mt-4">
                        <p class="text-forest-200/70 text-xs font-medium mb-2">Sudah termasuk:</p>
                        @foreach($selectedTrip->includes as $item)
                        <div class="flex items-center gap-2 text-forest-200/60 text-xs mb-1">
                            <svg class="w-3 h-3 text-forest-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $item }}
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="border-t border-forest-600 pt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-forest-200/70">Harga/orang</span>
                        <span class="text-white">{{ $selectedTrip->price_formatted }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-forest-200/70">Peserta</span>
                        <span class="text-white">× {{ $participants }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t border-forest-600 pt-3 mt-3">
                        <span class="text-white">Total</span>
                        <span class="text-forest-300">Rp {{ number_format($this->totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>
                @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-forest-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-forest-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                    <p class="text-forest-200/60 text-sm">Pilih trip untuk melihat ringkasan dan total harga</p>
                </div>
                @endif

                <button type="submit"
                        class="w-full mt-6 py-4 rounded-2xl font-bold text-white transition-all duration-300
                               {{ $selectedTrip ? 'bg-forest-500 hover:bg-forest-400 hover:shadow-lg hover:shadow-forest-500/30' : 'bg-forest-700 cursor-not-allowed opacity-50' }}"
                        {{ !$selectedTrip ? 'disabled' : '' }}>
                    <span wire:loading.remove wire:target="submit">Konfirmasi Booking</span>
                    <span wire:loading wire:target="submit" class="flex items-center justify-center gap-2">
                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        Memproses...
                    </span>
                </button>
            </div>
        </div>

    </form>
</div>
