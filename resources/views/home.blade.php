{{-- ================================================
     FILE: resources/views/home.blade.php
     FUNGSI: Halaman utama website
     ================================================ --}}

@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<style>
.hero {
    background: linear-gradient(135deg, #2563eb, #6366f1);
    color: white;
    padding: 80px 20px;
    border-radius: 0 0 40px 40px;
}
.hero h1 {
    font-weight: 700;
}
.hero p {
    opacity: .9;
}
.btn-primary {
    background: white;
    color: #2563eb;
    border-radius: 999px;
    padding: 12px 26px;
    font-weight: 600;
    transition: all .3s ease;
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,.15);
}
.btn-primary:active {
    transform: scale(.96);
}
.promo-card {
    border-radius: 18px;
    padding: 20px;
    color: white;
    transition: .3s;
}
.promo-yellow {
    background: linear-gradient(135deg, #f59e0b, #facc15);
}
.promo-blue {
    background: linear-gradient(135deg, #06b6d4, #2563eb);
}
.promo-card:hover {
    transform: translateY(-4px);
}
* {
    -webkit-tap-highlight-color: transparent;
}
button, a {
    transition: all .2s ease;
}
/* SECTION */
.category-section {
    padding: 60px 20px;
    background: #fff;
}

.section-title {
    text-align: center;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 40px;
}

/* GRID */
.category-grid {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 24px;
}

/* CARD */
.category-card {
    background: #ffffff;
    border-radius: 16px;
    text-decoration: none;
    color: #111;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.category-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

/* IMAGE FIX (INI KUNCI UTAMA) */
.category-image {
    width: 100%;
    height: 160px;
    overflow: hidden;
}

.category-image img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* 🔥 PENYELAMAT LAYOUT */
    display: block;
}

/* BODY */
.category-body {
    padding: 16px;
    text-align: center;
}

.category-body h4 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
    text-transform: capitalize;
}

.category-body span {
    display: inline-block;
    font-size: 13px;
    color: #555;
    background: #f1f3f5;
    padding: 4px 12px;
    border-radius: 20px;
}
</style>
    {{-- Hero Section --}}
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3">
                        Selamat datang di kantin Galih
                    </h1>
                    <p class="lead mb-4">
                        Temukan berbagai produk berkualitas dengan harga terbaik.
                        Gratis ongkir untuk pembelian pertama!
                    </p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-bag me-2"></i>Mulai Belanja
                    </a>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center">
                    <img src="{{ asset('images/snack sekolah.png') }}"
                         alt="Shopping" class="img-fluid" style="max-height: 400px;">
                </div>
            </div>
        </div>
    </section>

    {{-- Kategori --}}
    <section class="category-section">
        <h2 class="section-title">Kategori Populer</h2>

        <div class="category-grid">
            @foreach ($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="category-card">

                    <div class="category-image">
                        <img src="{{ asset('storage/' . $category->image) }}"
                             alt="{{ $category->name }}">
                    </div>

                    <div class="category-body">
                        <h4>{{ $category->name }}</h4>
                        <span>{{ $category->products_count }} Produk</span>
                    </div>

                </a>
            @endforeach
        </div>
    </section>

    {{-- Produk Unggulan --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Produk Unggulan</h2>
                <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="row g-4">
                @foreach($featuredProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Promo Banner --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card bg-warning text-dark border-0" style="min-height: 200px;">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h3>Flash Sale!</h3>
                            <p>Diskon hingga 50% untuk produk pilihan</p>
                            <a href="#" class="btn btn-dark" style="width: fit-content;">
                                Lihat Promo
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-info text-white border-0" style="min-height: 200px;">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h3>Member Baru?</h3>
                            <p>Dapatkan voucher Rp 50.000 untuk pembelian pertama</p>
                            <a href="{{ route('register') }}" class="btn btn-light" style="width: fit-content;">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Produk Terbaru --}}
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Produk Terbaru</h2>
            <div class="row g-4">
                @foreach($latestProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection