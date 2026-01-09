{{-- resources/views/orders/pay.blade.php --}}

@extends('layouts.app')

@section('title', 'Pembayaran Pesanan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-4">
                    <h1 class="h4 mb-0">Pembayaran Pesanan #{{ $order->order_number }}</h1>
                </div>

                <div class="card-body p-4">
                    {{-- Ringkasan Order --}}
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Ringkasan Pesanan</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                <p class="mb-1"><strong>Status:</strong> <span class="badge bg-warning">Menunggu Pembayaran</span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Pengiriman:</strong> {{ $order->shipping_name }}</p>
                                <p class="mb-0"><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Instruksi Pembayaran --}}
                    <div class="alert alert-info">
                        <h6 class="alert-heading">Instruksi Pembayaran</h6>
                        <p class="mb-0">Klik tombol "Bayar Sekarang" di bawah untuk melanjutkan ke halaman pembayaran Midtrans.</p>
                    </div>

                    {{-- Tombol Bayar --}}
                    @if($snapToken)
                    <div class="text-center">
                        <button id="pay-button" class="btn btn-primary btn-lg px-5 py-3">
                            💳 Bayar Sekarang
                        </button>
                        <div id="payment-error" class="mt-3 text-danger" style="display: none;"></div>
                    </div>

                    {{-- Load Snap JS --}}
                    <script src="{{ config('midtrans.snapUrl') }}"
                            data-client-key="{{ config('midtrans.clientKey') }}"></script>

                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const payButton = document.getElementById('pay-button');
                        const errorDiv = document.getElementById('payment-error');

                        payButton.addEventListener('click', function () {
                            payButton.disabled = true;
                            payButton.innerHTML = 'Memproses...';

                            snap.pay('{{ $snapToken }}', {
                                onSuccess: function () {
                                    window.location.href = "{{ route('orders.success', $order) }}";
                                },
                                onPending: function () {
                                    window.location.href = "{{ route('orders.pending', $order) }}";
                                },
                                onError: function () {
                                    errorDiv.textContent = 'Pembayaran gagal';
                                    errorDiv.style.display = 'block';
                                    payButton.disabled = false;
                                    payButton.innerHTML = '💳 Bayar Sekarang';
                                }
                            });
                        });
                    });
                    </script>
                    @else
                    <div class="alert alert-danger">
                        <strong>Error:</strong> Tidak dapat memuat token pembayaran. Silakan coba lagi atau hubungi admin.
                    </div>
                    @endif
                </div>

                <div class="card-footer text-center">
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">
                        ← Kembali ke Detail Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
