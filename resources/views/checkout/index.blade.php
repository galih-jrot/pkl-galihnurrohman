{{-- resources/views/checkout/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="bg-light min-vh-100 py-5">
    <div class="container">

        {{-- Title --}}
        <div class="mb-4">
            <h1 class="h4 fw-bold text-dark">Checkout</h1>
            <p class="text-muted small mb-0">
                Lengkapi informasi pengiriman dan periksa pesanan Anda
            </p>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            <div class="row g-4">

                {{-- LEFT --}}
                <div class="col-lg-8">

                    {{-- Shipping Info --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-bottom">
                            <h6 class="mb-0 fw-semibold text-secondary">
                                Informasi Pengiriman
                            </h6>
                        </div>

                        <div class="card-body p-4">
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-medium">
                                        Nama Penerima
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ auth()->user()->name }}"
                                        class="form-control"
                                        placeholder="Nama lengkap"
                                        required
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-medium">
                                        Nomor Telepon
                                    </label>
                                    <input
                                        type="text"
                                        name="phone"
                                        class="form-control"
                                        placeholder="08xxxxxxxxxx"
                                        required
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="form-label small fw-medium">
                                    Alamat Lengkap
                                </label>
                                <textarea
                                    name="address"
                                    rows="3"
                                    class="form-control"
                                    placeholder="Nama jalan, RT/RW, kecamatan, kota"
                                    required
                                ></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 position-sticky" style="top: 1.5rem">

                        <div class="card-header bg-white border-bottom">
                            <h6 class="mb-0 fw-semibold text-secondary">
                                Ringkasan Pesanan
                            </h6>
                        </div>

                        <div class="card-body px-4 py-3" style="max-height: 260px; overflow-y: auto">
                            @foreach($cart->items as $item)
                                <div class="d-flex justify-content-between align-items-start mb-2 small">
                                    <div class="me-2">
                                        <div class="fw-medium text-truncate">
                                            {{ $item->product->name }}
                                        </div>
                                        <div class="text-muted">
                                            Qty: {{ $item->quantity }}
                                        </div>
                                    </div>
                                    <div class="fw-semibold">
                                        {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="card-footer bg-white px-4 py-3">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total</span>
                                <span>
                                    Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="p-4 pt-3">
                            <button
                                type="submit"
                                class="btn btn-primary w-100 fw-semibold py-2"
                            >
                                Buat Pesanan
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </form>

    </div>
</div>
@endsection