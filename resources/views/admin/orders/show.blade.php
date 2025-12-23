@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->id)
@section('page-title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Pesanan</h5>
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-flex gap-2">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select form-select-sm" style="width: auto;">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">Update Status</button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">No. Pesanan</small>
                            <div class="fw-bold">#{{ $order->id }}</div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Tanggal Pesan</small>
                            <div>{{ $order->created_at->format('d M Y H:i') }}</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">Customer</small>
                            <div>{{ $order->user->name }}</div>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Metode Pembayaran</small>
                            <div>{{ $order->payment_method === 'bank_transfer' ? 'Transfer Bank' : 'Bayar di Tempat' }}</div>
                        </div>
                    </div>

                    @if($order->notes)
                        <div class="mb-3">
                            <small class="text-muted">Catatan</small>
                            <div>{{ $order->notes }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Produk Dipesan</h5>
                </div>
                <div class="card-body">
                    @foreach($order->orderItems as $item)
                        <div class="d-flex align-items-center mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
                                 class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $item->product->name }}</h6>
                                <small class="text-muted">Qty: {{ $item->quantity }}</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                                <small class="text-muted">@ Rp {{ number_format($item->price, 0, ',', '.') }} per item</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Ringkasan Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkos Kirim</span>
                        <span>Gratis</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
