<div x-data="{ addedKey: null }">

    {{-- Flash Message --}}
    @if($flashMessage)
    <div x-data="{ show: true }"
         x-init="setTimeout(() => { show = false; $wire.clearFlash() }, 3000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 bg-forest-500 text-white px-6 py-3 rounded-full shadow-xl font-medium text-sm">
        {{ $flashMessage }}
    </div>
    @endif

    {{-- CART SIDEBAR --}}
    <div x-data x-show="$wire.showCart"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-50 flex justify-end"
         style="display: none">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="$set('showCart', false)"></div>
        <div x-show="$wire.showCart"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="relative w-full max-w-md bg-forest-800 h-full flex flex-col shadow-2xl">

            <div class="flex items-center justify-between p-6 border-b border-forest-700">
                <h3 class="font-serif text-xl font-bold text-white">Keranjang Belanja</h3>
                <button wire:click="$set('showCart', false)" class="text-forest-300 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                @forelse($cart as $key => $item)
                <div class="flex gap-4 bg-forest-700 rounded-2xl p-4">
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                         class="w-16 h-16 object-cover rounded-xl flex-shrink-0" />
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-medium text-sm truncate">{{ $item['name'] }}</p>
                        @if($item['size']) <p class="text-forest-300 text-xs">Ukuran: {{ $item['size'] }}</p> @endif
                        <p class="text-forest-300 text-sm font-semibold">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <button wire:click="updateQty('{{ $key }}', {{ $item['qty'] - 1 }})"
                                    class="w-7 h-7 rounded-full bg-forest-600 hover:bg-forest-500 text-white text-sm flex items-center justify-center transition-colors">−</button>
                            <span class="text-white text-sm font-medium w-4 text-center">{{ $item['qty'] }}</span>
                            <button wire:click="updateQty('{{ $key }}', {{ $item['qty'] + 1 }})"
                                    class="w-7 h-7 rounded-full bg-forest-600 hover:bg-forest-500 text-white text-sm flex items-center justify-center transition-colors">+</button>
                        </div>
                    </div>
                    <div class="flex flex-col items-end justify-between">
                        <button wire:click="removeFromCart('{{ $key }}')" class="text-red-400 hover:text-red-300 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                        <p class="text-white font-semibold text-sm">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-16">
                    <div class="text-6xl mb-4">🛒</div>
                    <p class="text-forest-200/60">Keranjang masih kosong</p>
                    <p class="text-forest-200/40 text-sm mt-1">Tambahkan produk favoritmu!</p>
                </div>
                @endforelse
            </div>

            @if(count($cart) > 0)
            <div class="p-6 border-t border-forest-700">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-forest-200/70">Total ({{ $cartCount }} item)</span>
                    <span class="text-xl font-bold text-forest-300">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                </div>
                <a href="https://wa.me/628?text={{ urlencode('Halo BV! Saya ingin memesan merchandise:\n' . collect($cart)->map(fn($i) => "- {$i['name']}" . ($i['size'] ? " ({$i['size']})" : '') . " x{$i['qty']}") ->implode('\n') . '\nTotal: Rp ' . number_format($cartTotal, 0, ',', '.')) }}"
                   target="_blank"
                   class="w-full block text-center btn-primary py-4">
                    Pesan via WhatsApp 📲
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- QUICK VIEW MODAL --}}
    @if($quickViewProduct)
    <div class="fixed inset-0 z-40 flex items-center justify-center p-4"
         x-data x-init="$el.style.display='flex'">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" wire:click="closeQuickView"></div>
        <div class="relative bg-forest-700 rounded-3xl max-w-2xl w-full overflow-hidden shadow-2xl
                    animate-[fadeInUp_0.3s_ease-out]">
            <button wire:click="closeQuickView" class="absolute top-4 right-4 z-10 text-forest-300 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="grid md:grid-cols-2">
                <img src="{{ $quickViewProduct->image }}" alt="{{ $quickViewProduct->name }}"
                     class="w-full h-64 md:h-full object-cover" />
                <div class="p-8" x-data="{ size: '' }">
                    <p class="text-forest-300 text-xs uppercase tracking-widest mb-2">{{ ucfirst($quickViewProduct->category) }}</p>
                    <h3 class="font-serif text-2xl font-bold text-white mb-2">{{ $quickViewProduct->name }}</h3>
                    <p class="text-forest-300 text-xl font-bold mb-4">{{ $quickViewProduct->price_formatted }}</p>
                    <p class="text-forest-200/70 text-sm leading-relaxed mb-6">{{ $quickViewProduct->description }}</p>

                    @if($quickViewProduct->sizes && count($quickViewProduct->sizes) > 1)
                    <div class="mb-6">
                        <p class="text-forest-200/70 text-sm mb-2 font-medium">Pilih Ukuran</p>
                        <div class="flex gap-2 flex-wrap">
                            @foreach($quickViewProduct->sizes as $sz)
                            <button @click="size = '{{ $sz }}'"
                                    :class="size === '{{ $sz }}' ? 'bg-forest-300 text-forest-900 border-forest-300' : 'border-forest-500 text-white hover:border-forest-300'"
                                    class="px-4 py-2 border rounded-lg text-sm font-medium transition-all">
                                {{ $sz }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <button @click="wire.addToCart({{ $quickViewProduct->id }}, size)"
                            wire:click="addToCart({{ $quickViewProduct->id }}, '')"
                            class="w-full btn-primary py-3">
                        Tambah ke Keranjang
                    </button>
                    <p class="text-forest-200/40 text-xs text-center mt-3">Stok: {{ $quickViewProduct->stock }} tersisa</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        {{-- Category Filter --}}
        <div class="flex gap-2 flex-wrap">
            @foreach(['all' => 'Semua', 'apparel' => 'Pakaian', 'accessories' => 'Aksesoris', 'gear' => 'Gear'] as $val => $label)
            <button wire:click="$set('selectedCategory', '{{ $val }}')"
                    class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300
                           {{ $selectedCategory === $val ? 'bg-forest-500 text-white' : 'bg-forest-700 text-forest-200 hover:bg-forest-600' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- Cart Button --}}
        <button wire:click="$set('showCart', true)"
                class="relative flex items-center gap-2 px-4 py-2 bg-forest-700 hover:bg-forest-600 rounded-full transition-colors">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span class="text-white text-sm font-medium">Keranjang</span>
            @if($cartCount > 0)
            <span class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-forest-300 text-forest-900 rounded-full text-xs font-bold flex items-center justify-center">
                {{ $cartCount }}
            </span>
            @endif
        </button>
    </div>

    {{-- PRODUCTS GRID --}}
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $product)
        <div class="card-dark group"
             x-data="{ selectedSize: '', added: false }">
            <div class="relative overflow-hidden h-64 cursor-pointer"
                 wire:click="openQuickView({{ $product->id }})">
                <img src="{{ $product->image }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <span class="bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-medium border border-white/30">
                        Quick View
                    </span>
                </div>
                <div class="absolute top-3 left-3">
                    <span class="px-2.5 py-1 bg-forest-500/90 backdrop-blur-sm text-white text-xs font-semibold rounded-full">
                        {{ ucfirst($product->category) }}
                    </span>
                </div>
                @if($product->stock <= 5 && $product->stock > 0)
                <div class="absolute top-3 right-3">
                    <span class="px-2.5 py-1 bg-amber-500/90 backdrop-blur-sm text-white text-xs font-semibold rounded-full">
                        Hampir Habis!
                    </span>
                </div>
                @endif
            </div>

            <div class="p-5">
                <h3 class="font-semibold text-white mb-1">{{ $product->name }}</h3>
                <p class="text-forest-200/60 text-sm line-clamp-2 mb-3">{{ $product->description }}</p>
                <p class="text-forest-300 font-bold text-lg mb-4">{{ $product->price_formatted }}</p>

                @if($product->sizes && count($product->sizes) > 1)
                <div class="flex gap-1.5 mb-4 flex-wrap">
                    @foreach($product->sizes as $sz)
                    <button @click="selectedSize = '{{ $sz }}'"
                            :class="selectedSize === '{{ $sz }}' ? 'bg-forest-500 text-white border-forest-500' : 'border-forest-500 text-forest-300 hover:border-forest-300'"
                            class="px-3 py-1 border rounded-lg text-xs font-medium transition-all">
                        {{ $sz }}
                    </button>
                    @endforeach
                </div>
                @else
                <div class="mb-4"></div>
                @endif

                <button
                    @click="added = true; setTimeout(() => added = false, 1500)"
                    wire:click="addToCart({{ $product->id }}, '')"
                    :class="added ? 'bg-green-600 scale-95' : 'bg-forest-500 hover:bg-forest-400'"
                    class="w-full py-3 text-white font-semibold rounded-xl transition-all duration-200">
                    <span x-show="!added">+ Tambah ke Keranjang</span>
                    <span x-show="added" class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Ditambahkan!
                    </span>
                </button>
            </div>
        </div>
        @endforeach
    </div>
</div>
