<?php
namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Ambil atau buat cart (User / Guest)
     */
    public function getCart(): Cart
    {
        if (Auth::check()) {
            return Cart::firstOrCreate([
                'user_id' => Auth::id(),
            ]);
        }

        return Cart::firstOrCreate([
            'session_id' => Session::getId(),
        ]);
    }

    /**
     * Ambil semua item di cart
     */
    public function getItems()
    {
        return $this->getCart()
            ->items()
            ->with('product')
            ->get();
    }

    /**
     * Tambah produk ke cart
     */
    public function addProduct(Product $product, int $quantity = 1): void
    {
        $cart = $this->getCart();

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $newQty = $item->quantity + $quantity;

            if ($newQty > $product->stock) {
                throw new \Exception("Stok tidak mencukupi. Maksimal {$product->stock}");
            }

            $item->update([
                'quantity' => $newQty,
            ]);
        } else {
            if ($quantity > $product->stock) {
                throw new \Exception("Stok tidak mencukupi.");
            }

            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $quantity,
            ]);
        }

        $cart->touch();
    }

    /**
     * Update quantity item
     */
    public function updateQuantity(int $itemId, int $quantity): void
    {
        $item = CartItem::with('product', 'cart')->findOrFail($itemId);

        $this->verifyCartOwnership($item->cart);

        if ($quantity > $item->product->stock) {
            throw new \Exception("Stok tidak mencukupi. Tersisa {$item->product->stock}");
        }

        if ($quantity <= 0) {
            $item->delete();
        } else {
            $item->update([
                'quantity' => $quantity,
            ]);
        }
    }

    /**
     * Hapus item dari cart
     */
    public function removeItem(int $itemId): void
    {
        $item = CartItem::with('cart')->findOrFail($itemId);

        $this->verifyCartOwnership($item->cart);

        $item->delete();
    }

    /**
     * Hitung total harga cart
     */
    public function getTotalPrice(): int
    {
        return $this->getCart()->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }

    /**
     * Kosongkan cart (checkout / logout)
     */
    public function clearCart(): void
    {
        $this->getCart()->items()->delete();
    }

    /**
     * Merge cart guest ke user saat login
     */
    public function mergeCartOnLogin(): void
    {
        $sessionId = Session::getId();

        $guestCart = Cart::where('session_id', $sessionId)
            ->with('items')
            ->first();

        if (! $guestCart) {
            return;
        }

        $userCart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        foreach ($guestCart->items as $item) {
            $existing = $userCart->items()
                ->where('product_id', $item->product_id)
                ->first();

            if ($existing) {
                $existing->increment('quantity', $item->quantity);
                $item->delete();
            } else {
                $item->update([
                    'cart_id' => $userCart->id,
                ]);
            }
        }

        $guestCart->delete();
    }

    /**
     * Pastikan cart milik user / session aktif
     */
    private function verifyCartOwnership(Cart $cart): void
    {
        $currentCart = $this->getCart();

        if ($cart->id !== $currentCart->id) {
            abort(403, 'Akses ditolak');
        }
    }
}
