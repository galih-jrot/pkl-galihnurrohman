{{-- ================================================
 FILE: resources/views/catalog/show.blade.php
 FUNGSI: Halaman detail produk
 TEMA: Biru Kantin Sekolah
================================================ --}}

@extends('layouts.app')

@section('title', $product->name)

@section('content')

<style>
:root {
    --blue-main: #0d6efd;
    --blue-strong: #0a58ca;
    --blue-soft: #eaf2ff;
}

/* PAGE BG */
.detail-bg {
    background: linear-gradient(to bottom, #eaf2ff, #ffffff);
}

/* CARD */
.detail-card {
    border-radius: 1.75rem;
    border: none;
    box-shadow: 0 18px 40px rgba(13,110,253,.25);
}

/* IMAGE */
.product-image {
    height: 420px;
    object-fit: contain;
    background: radial-gradient(circle, #ffffff, #eaf2ff);
}

/* BADGE */
.badge-category {
    background: #dbeafe;
    color: #084298;
    font-weight: 600;
}

/* PRICE */
.price-main {
    color: var(--blue-main);
    font-weight: 800;
}

/* THUMBNAIL */
.thumb-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border: 2px solid #dbeafe;
    transition: .2s;
}
.thumb-img:hover {
    border-color: var(--blue-main);
    transform: scale(1.05);
}

/* BUTTON */
.btn-primary {
    background: linear-gradient(to right, #0a58ca, #0d6efd);
    border: none;
}
</style>

<div class="detail-bg py-5">
<div class="container">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Katalog</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}">
                    {{ $product->category->name }}
                </a>
            </li>
            <li class="breadcrumb-item active">{{ Str::limit($product->name, 30) }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- IMAGE --}}
        <div class="col-lg-6">
            <div class="card detail-card">
                <div class="position-relative">
                    <img src="{{ $product->image_url }}"
                         id="main-image"
                         class="card-img-top product-image"
                         alt="{{ $product->name }}">

                    @if($product->has_discount)
                        <span class="badge bg-danger position-absolute top-0 start-0 m-3 fs-6">
                            -{{ $product->discount_percentage }}%
                        </span>
                    @endif
                </div>

                @if($product->images->count() > 1)
                <div class="card-body">
                    <div class="d-flex gap-2 overflow-auto">
                        @foreach($product->images as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                 class="rounded thumb-img"
                                 onclick="document.getElementById('main-image').src = this.src">
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- INFO --}}
        <div class="col-lg-6">
            <div class="card detail-card h-100">
                <div class="card-body">

                    <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}"
                       class="badge badge-category mb-2 text-decoration-none">
                        {{ $product->category->name }}
                    </a>

                    <h2 class="fw-bold mb-3">{{ $product->name }}</h2>

                    <div class="mb-4">
                        @if($product->has_discount)
                            <div class="text-muted text-decoration-line-through">
                                {{ $product->formatted_original_price }}
                            </div>
                        @endif
                        <div class="h3 price-main">
                            {{ $product->formatted_price }}
                        </div>
                    </div>

                    {{-- STOCK --}}
                    <div class="mb-4">
                        @if($product->stock > 10)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i> Stok Tersedia
                            </span>
                        @elseif($product->stock > 0)
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-exclamation-triangle me-1"></i> Stok Tinggal {{ $product->stock }}
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle me-1"></i> Stok Habis
                            </span>
                        @endif
                    </div>

                    {{-- CART --}}
                    <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="row g-3 align-items-end">
                            <div class="col-auto">
                                <label class="form-label">Jumlah</label>
                                <div class="input-group" style="width: 140px;">
                                    <button type="button" class="btn btn-outline-secondary"
                                            onclick="decrementQty()">-</button>
                                    <input type="number" name="quantity" id="quantity"
                                           value="1" min="1" max="{{ $product->stock }}"
                                           class="form-control text-center">
                                    <button type="button" class="btn btn-outline-secondary"
                                            onclick="incrementQty()">+</button>
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-lg w-100"
                                        @if($product->stock == 0) disabled @endif>
                                    <i class="bi bi-cart-plus me-2"></i>
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </form>

                    @auth
                        <button type="button"
                                onclick="toggleWishlist({{ $product->id }})"
                                class="btn btn-outline-danger mb-4 wishlist-btn-{{ $product->id }}">
                            <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill' : 'bi-heart' }} me-2"></i>
                            {{ auth()->user()->hasInWishlist($product) ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}
                        </button>
                    @endauth

                    <hr>

                    <h6>Deskripsi</h6>
                    <p class="text-muted">{!! nl2br(e($product->description)) !!}</p>

                    <div class="row text-muted small">
                        <div class="col-6">
                            <i class="bi bi-box me-2"></i> Berat: {{ $product->weight }} gram
                        </div>
                        <div class="col-6">
                            <i class="bi bi-tag me-2"></i> SKU: PROD-{{ $product->id }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>

@push('scripts')
<script>
function incrementQty() {
    const input = document.getElementById('quantity');
    if (+input.value < +input.max) input.value++;
}
function decrementQty() {
    const input = document.getElementById('quantity');
    if (+input.value > 1) input.value--;
}
</script>
@endpush

@endsection