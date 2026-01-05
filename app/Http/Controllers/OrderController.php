<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = auth()->user()->orders()->with(['orderItems.product'])->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        // Pastikan user hanya bisa lihat order miliknya sendiri
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['orderItems.product', 'user']);

        // Generate snap token jika order masih pending dan belum dibayar
        $snapToken = null;
        if ($order->status === 'pending' && $order->payment_status === 'unpaid') {
            try {
                $midtransService = app(\App\Services\MidtransService::class);
                $snapToken = $midtransService->createSnapToken($order);

                // Simpan snap token ke database jika belum ada
                if (!$order->snap_token) {
                    $order->update(['snap_token' => $snapToken]);
                } else {
                    // Gunakan yang sudah ada jika sudah tersimpan
                    $snapToken = $order->snap_token;
                }
            } catch (\Exception $e) {
                // Log error tapi jangan hentikan halaman
                logger()->error('Failed to generate snap token', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('orders.show', compact('order', 'snapToken'));
    }
}
