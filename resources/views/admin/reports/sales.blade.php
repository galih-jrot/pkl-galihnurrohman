{{-- ================================================
     FILE: resources/views/admin/reports/sales.blade.php
     FUNGSI: Menampilkan laporan penjualan
     ================================================ --}}

@extends('layouts.admin')

@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')

@section('content')
<div class="row g-4">
    {{-- Filter Periode --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Filter Periode Laporan</h6>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                               value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                               value="{{ request('end_date', now()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status Pesanan</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.reports.export-sales') }}" class="btn btn-success">
                            <i class="bi bi-download me-1"></i> Export Excel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="col-12">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="display-6 text-primary">{{ $summary['total_orders'] ?? 0 }}</div>
                        <div class="text-muted">Total Pesanan</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="display-6 text-success">Rp {{ number_format($summary['total_revenue'] ?? 0, 0, ',', '.') }}</div>
                        <div class="text-muted">Total Pendapatan</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="display-6 text-info">{{ $summary['total_products_sold'] ?? 0 }}</div>
                        <div class="text-muted">Produk Terjual</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="display-6 text-warning">{{ $summary['total_customers'] ?? 0 }}</div>
                        <div class="text-muted">Pelanggan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Detail Penjualan --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Detail Penjualan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales ?? [] as $sale)
                                <tr>
                                    <td>{{ $sale->order_date }}</td>
                                    <td>{{ $sale->order_number }}</td>
                                    <td>{{ $sale->customer_name }}</td>
                                    <td>{{ $sale->product_name }}</td>
                                    <td>{{ $sale->quantity }}</td>
                                    <td>Rp {{ number_format($sale->price, 0, ',', '.') }}</td>
                                    <td>
                                        @include('components.order-status-badge', ['status' => $sale->order_status])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Tidak ada data penjualan untuk periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if(isset($sales) && $sales->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $sales->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
