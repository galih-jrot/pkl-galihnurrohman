@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<style>
.stat-card {
    background: white;
    border-left: 5px solid;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 8px 20px rgba(0,0,0,.05);
    transition: .3s;
}
.stat-card:hover {
    transform: translateY(-5px);
}
.stat-card i {
    font-size: 32px;
    opacity: .3;
}
.product-item {
    display: flex;
    gap: 12px;
    padding: 10px 0;
}
.product-item img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid #eee;
}
.table tbody tr:hover {
    background: #f1f5f9;
}
.card {
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,.05);
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Dashboard Admin</h1>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card border-primary">
                <div>
                    <p>Total Pendapatan</p>
                    <h4>Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h4>
                </div>
                <i class="bi bi-cash-stack"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card border-success">
                <div>
                    <p>Total Pesanan</p>
                    <h4>{{ $stats['total_orders'] }}</h4>
                </div>
                <i class="bi bi-bag-check"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card border-warning">
                <div>
                    <p>Pesanan Pending</p>
                    <h4>{{ $stats['pending_orders'] }}</h4>
                </div>
                <i class="bi bi-clock"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card border-danger">
                <div>
                    <p>Stok Rendah</p>
                    <h4>{{ $stats['low_stock'] }}</h4>
                </div>
                <i class="bi bi-exclamation-triangle"></i>
            </div>
        </div>
    </div>

    <!-- Charts and Tables -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        @if($periode == 1)
                            Pendapatan 1 Hari Terakhir
                        @elseif($periode == 7)
                            Pendapatan 7 Hari Terakhir
                        @elseif($periode == 30)
                            Pendapatan Bulanan
                        @else
                            Pendapatan {{ $periode }} Hari Terakhir
                        @endif
                    </h6>
                    <form method="GET" class="d-inline">
                        <select name="periode" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="1" {{ $periode == 1 ? 'selected' : '' }}>1 Hari</option>
                            <option value="7" {{ $periode == 7 ? 'selected' : '' }}>7 Hari</option>
                            <option value="30" {{ $periode == 30 ? 'selected' : '' }}>Bulanan</option>
                            <option value="365" {{ $periode == 365 ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </form>
                </div>
                <div class="card-body">
                    @if($revenueChart->sum('total') == 0)
                        <p class="text-muted text-center mt-5">Belum ada pendapatan</p>
                    @else
                        <canvas id="revenueChart"></canvas>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Produk Terlaris</h6>
                </div>
                <div class="card-body">
                    @foreach($topProducts as $product)
                        <div class="product-item">
                            <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('img/no-image.png') }}" alt="{{ $product->name }}">
                            <div>
                                <strong>{{ $product->name }}</strong>
                                <small>Terjual: {{ $product->sold }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pesanan Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if($order->status == 'completed' || $order->status == 1)
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif($order->status == 'pending' || $order->status == 0)
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($order->status == 'processing')
                                                <span class="badge bg-info">Diproses</span>
                                            @else
                                                <span class="badge bg-danger">Batal</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
@if($revenueChart->sum('total') > 0)
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueData = @json($revenueChart);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: revenueData.map(item => {
                if (item.date) {
                    // Data harian
                    const date = new Date(item.date);
                    return date.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit' });
                } else if (item.year && item.month) {
                    // Data bulanan
                    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                    return `${monthNames[item.month - 1]} ${item.year}`;
                }
                return '';
            }),
            datasets: [{
                label: 'Pendapatan',
                data: revenueData.map(item => item.total),
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79,70,229,0.2)',
                tension: 0.4,
                fill: true,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: value => 'Rp ' + value.toLocaleString('id-ID')
                    }
                }
            }
        }
    });
});
@endif
</script>
@endsection
