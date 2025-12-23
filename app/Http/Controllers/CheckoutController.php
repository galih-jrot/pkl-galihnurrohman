<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View
    {
        $cart = auth()->user()->cart()->with('cartItems.product')->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }

        $total = $cart->cartItems->sum(function ($item) {
            return $item->quantity * $item->product->display_price;
        });

        return view('checkout.index', compact('cart', 'total'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'payment_method' => 'required|in:bank_transfer,cod',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = auth()->user()->cart()->with('cartItems.product')->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();
        try {
            // Buat order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $cart->cartItems->sum(fn($item) => $item->quantity * $item->product->display_price),
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
            ]);

            // Buat order items
            foreach ($cart->cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->display_price,
                ]);

                // Kurangi stok
                $cartItem->product->decrementStock($cartItem->quantity);
            }

            // Kosongkan cart
            $cart->cartItems()->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }
}
