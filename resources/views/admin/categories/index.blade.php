@extends('layouts.admin')

@section('title', 'Kategori')
@section('page-title', 'Daftar Kategori')

@section('content')
<div class="container-fluid px-0">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Kategori</h5>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                + Tambah Baru
            </a>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th>Nama Kategori</th>
                    <th width="120">Produk</th>
                    <th width="120">Status</th>
                    <th width="120" class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $category->name }}</div>
                            <small class="text-muted">{{ $category->slug }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info">
                                {{ $category->products_count ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-success">Aktif</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="btn btn-warning btn-sm">
                                ✏️
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Data kategori belum ada
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
