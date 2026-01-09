<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // ===============================
        // KONFIGURASI MIDTRANS
        // ===============================
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        // Ambil data JSON dari Midtrans
        $payload = $request->all();

        // ===============================
        // VALIDASI SIGNATURE KEY
        // ===============================
        $signatureKey = hash(
            'sha512',
            $payload['order_id'] .
            $payload['status_code'] .
            $payload['gross_amount'] .
            config('midtrans.server_key')
        );

        if ($signatureKey !== $payload['signature_key']) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // ===============================
        // CARI ORDER
        // ===============================
        $order = Order::where('order_number', $payload['order_id'])->first();

        if (! $order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // ===============================
        // UPDATE STATUS ORDER
        // ===============================
        switch ($payload['transaction_status']) {
            case 'capture':
            case 'settlement':
                $order->update(['status' => 'paid']);
                break;

            case 'pending':
                $order->update(['status' => 'pending']);
                break;

            case 'expire':
            case 'cancel':
            case 'deny':
                $order->update(['status' => 'failed']);
                break;
        }

        return response()->json(['message' => 'Webhook processed']);
    }
}
