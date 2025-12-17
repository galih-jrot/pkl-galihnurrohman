<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tentang', function () {
    return view('tentang');
    });

Route::get('/sapa/{nama}', function ($nama) {
    // ↑ '/sapa/{nama}' = URL pattern
    // ↑ {nama}         = Parameter dinamis, nilainya dari URL
    // ↑ function($nama) = Parameter diterima di function

    return "Halo semua selamat datang di Toko Online.";
    // ↑ "$nama" = Variable interpolation (masukkan nilai $nama ke string)
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
