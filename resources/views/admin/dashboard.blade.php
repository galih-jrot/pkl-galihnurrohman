@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4">
    {{-- Statistik Cards --}}
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-primary mb-2">
                    <i class="bi bi-box-seam fs-1"></i>
                </div>
                <h4 class="card-title mb-1">{{ number_format($stats['total_products']) }}</h4>
                <p class="card-text text-muted small">Total Produk</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-success mb-2">
                    <i class="bi bi-people fs-1"></i>
                </div>
                <h4 class="card-title mb-1">{{ number_format($stats['total_users']) }}</h4>
                <p class="card-text text-muted small">Total Pengguna</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-info mb-2">
                    <i class="bi bi-receipt fs-1"></i>
                </div>
                <h4 class="card-title mb-1">{{ number_format($stats['total_orders']) }}</h4>
                <p class="card-text text-muted small">Total Pesanan</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-warning mb-2">
                    <i class="bi bi-clock fs-1"></i>
                </div>
                <h4 class="card-title mb-1">{{ number_format($stats['pending_orders']) }}</h4>
                <p class="card-text text-muted small">Pesanan Pending</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    {{-- Pesanan Terbaru --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Pesanan Terbaru</h5>
            </div>
            <div class="card-body">
                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>Rp {{ number_format($order->total_amount) }}</td>
                                        <td>
                                            <span class="badge
                                                @if($order->status == 'pending') bg-warning text-dark
                                                @elseif($order->status == 'processing') bg-info
                                                @elseif($order->status == 'shipped') bg-primary
                                                @elseif($order->status == 'delivered') bg-success
                                                @else bg-secondary
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-receipt text-muted fs-1 mb-3"></i>
                        <p class="text-muted">Belum ada pesanan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
