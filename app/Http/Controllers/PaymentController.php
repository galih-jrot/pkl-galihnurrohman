<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;

class PaymentController extends Controller
{
    /**
     * Mengambil Snap Token untuk order ini (API Endpoint).
     * Dipanggil via AJAX dari frontend saat user klik "Bayar".
     */
    public function getSnapToken(Order $order, MidtransService $midtransService)
    {
        // 1. Authorization: Pastikan user adalah pemilik order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // 2. Cek apakah order sudah dibayar
        if ($order->payment_status === 'paid') {
            return response()->json(['error' => 'Pesanan sudah dibayar.'], 400);
        }

        try {
            // 3. Generate Snap Token dari Midtrans
            $snapToken = $midtransService->createSnapToken($order);

            // 4. Simpan token ke database untuk referensi
            $order->update(['snap_token' => $snapToken]);

            // 5. Kirim token ke frontend
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success(Order $order)
    {
        // pastikan hanya pemilik order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // jangan update ulang kalau sudah paid
        if ($order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'paid_at'        => now(),
            ]);
        }

        return view('orders.success', compact('order'));
    }

    public function pending(Order $order)
    {
        // Optional: pastikan order milik user
        abort_if($order->user_id !== auth()->id(), 403);

        return view('orders.pending', compact('order'));
    }
}
