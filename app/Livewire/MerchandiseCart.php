<?php

namespace App\Livewire;

use App\Models\Merchandise;
use Livewire\Component;

class MerchandiseCart extends Component
{
    public array $cart = [];
    public bool $showCart = false;
    public ?int $quickViewId = null;
    public string $flashMessage = '';
    public string $selectedCategory = 'all';

    public function mount(): void
    {
        $this->cart = session('bv_cart', []);
    }

    public function cartCount(): int
    {
        return array_sum(array_column($this->cart, 'qty'));
    }

    public function cartTotal(): float
    {
        return array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $this->cart));
    }

    public function addToCart(int $productId, string $size = ''): void
    {
        $product = Merchandise::find($productId);
        if (! $product) {
            return;
        }

        $key = $productId . '_' . $size;

        if (isset($this->cart[$key])) {
            $this->cart[$key]['qty']++;
        } else {
            $this->cart[$key] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => (float) $product->price,
                'image' => $product->image,
                'size'  => $size,
                'qty'   => 1,
            ];
        }

        session(['bv_cart' => $this->cart]);
        $this->flashMessage = "✓ {$product->name} ditambahkan ke keranjang!";
        $this->dispatch('cart-updated');
    }

    public function removeFromCart(string $key): void
    {
        unset($this->cart[$key]);
        session(['bv_cart' => $this->cart]);
    }

    public function updateQty(string $key, int $qty): void
    {
        if ($qty < 1) {
            $this->removeFromCart($key);
            return;
        }
        $this->cart[$key]['qty'] = $qty;
        session(['bv_cart' => $this->cart]);
    }

    public function clearFlash(): void
    {
        $this->flashMessage = '';
    }

    public function openQuickView(int $productId): void
    {
        $this->quickViewId = $productId;
    }

    public function closeQuickView(): void
    {
        $this->quickViewId = null;
    }

    public function render()
    {
        $query = Merchandise::where('is_active', true);

        if ($this->selectedCategory !== 'all') {
            $query->where('category', $this->selectedCategory);
        }

        $products = $query->get();
        $quickViewProduct = $this->quickViewId ? Merchandise::find($this->quickViewId) : null;

        return view('livewire.merchandise-cart', [
            'products'         => $products,
            'quickViewProduct' => $quickViewProduct,
            'cartCount'        => $this->cartCount(),
            'cartTotal'        => $this->cartTotal(),
        ]);
    }
}
