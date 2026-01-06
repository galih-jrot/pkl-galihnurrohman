<?php
// config/midtrans.php

return [
    'merchantId'   => env('MIDTRANS_MERCHANT_ID'),
    'clientKey'    => env('MIDTRANS_CLIENT_KEY'),
    'serverKey'    => env('MIDTRANS_SERVER_KEY'),

    // Environment: Sandbox (Testing) vs Production (Real Money)
    // Jangan sampai tertukar! Server Key Production beda dengan Sandbox.
    'isProduction' => env('MIDTRANS_IS_PRODUCTION', false),

    // Sanitized: Membersihkan input dari karakter aneh yang bisa merusak request
    'isSanitized'  => env('MIDTRANS_IS_SANITIZED', true),

    // 3DS (3-D Secure): Wajib ON untuk transaksi Kartu Kredit (Visa/Mastercard)
    // agar user diminta OTP oleh bank penerbit. Standar keamanan BI.
    'is3ds'        => env('MIDTRANS_IS_3DS', true),

    // URL untuk Snap JS (berbeda untuk Sandbox dan Production)
    // Script ini akan diload di frontend (Blade)
    'snapUrl'      => env('MIDTRANS_IS_PRODUCTION', false)
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js',
];
