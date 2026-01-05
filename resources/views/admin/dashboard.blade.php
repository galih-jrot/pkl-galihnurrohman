{{-- ================================================
     FILE: resources/views/admin/dashboard.blade.php
     FUNGSI: Halaman dashboard admin dengan statistik dan data real-time
     ================================================ --}}

@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4">
    {{-- Statistik Cards --}}
    <div class="col-12">
        <div class="row g-3">
            {{-- Total Revenue --}}
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-currency-dollar text-success fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title mb-1 text-muted">Total Pendapatan</h6>
                                <h4 class="mb-0 text-success">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Orders --}}
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-receipt text-primary fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title mb-1 text-muted">Total Pesanan</h6>
                                <h4 class="mb-0 text-primary">{{ number_format($stats['total_orders']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pending Orders --}}
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-clock text-warning fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title mb-1 text-muted">Pesanan Pending</h6>
                                <h4 class="mb-0 text-warning">{{ number_format($stats['pending_orders']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Products --}}
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-info bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-box-seam text-info fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title mb-1 text-muted">Total Produk</h6>
                                <h4 class="mb-0 text-info">{{ number_format($stats['total_products']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Additional Stats --}}
    <div class="col-12">
        <div class="row g-3">
            {{-- Total Customers --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-secondary bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-people text-secondary fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title mb-1 text-muted">Total Pelanggan</h6>
                                <h4 class="mb-0 text-secondary">{{ number_format($stats['total_customers']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Low Stock Alert --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-danger bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title mb-1 text-muted">Stok Rendah (≤5)</h6>
                                <h4 class="mb-0 text-danger">{{ number_format($stats['low_stock']) }}</h4>
                                @if($stats['low_stock'] > 0)
                                    <small class="text-danger">Perlu restock segera!</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts and Tables --}}
    <div class="col-lg-8">
        {{-- Revenue Chart --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0">Pendapatan 7 Hari Terakhir</h6>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" width="100%" height="300"></canvas>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Pesanan Terbaru</h6>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none">
                                            {{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td>
                                        @include('components.order-status-badge', ['status' => $order->status])
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Belum ada pesanan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Produk Terlaris</h6>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @forelse($topProducts as $product)
                    <div class="d-flex align-items-center p-3 border-bottom">
                        <img src="{{ $product->image_url }}"
                             class="rounded me-3"
                             width="50" height="50"
                             style="object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ Str::limit($product->name, 30) }}</h6>
                            <small class="text-muted">{{ $product->sold }} terjual</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        Belum ada produk terjual
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueData = @json($revenueChart);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: revenueData.map(item => {
                const date = new Date(item.date);
                return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
            }),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: revenueData.map(item => item.total),
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endpush
