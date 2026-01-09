{{-- ========================================
FILE: resources/views/auth/login.blade.php
FUNGSI: Halaman Login (Tema TokoSnack)
======================================== --}}

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">

        <div class="col-md-6 col-lg-5">
          

            <div class="card shadow border-0 rounded-4 overflow-hidden">

                {{-- ===== HEADER + LOGO ===== --}}
                
                <div class="bg-primary text-white text-center p-4">
                    {{-- Logo --}}
                    

                    <h4 class="fw-bold mb-1">Selamat Datang 👋</h4>
                    <p class="mb-0 opacity-75">
                        Login untuk melanjutkan ke <strong>TokoSnack</strong>
                    </p>
                </div>

                {{-- ===== BODY ===== --}}
                <div class="card-body p-4">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                Email
                            </label>
                            <input
                                id="email"
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                placeholder="nama@email.com"
                            >

                            @error('email')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                Password
                            </label>
                            <input
                                id="password"
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                required
                                placeholder="••••••••"
                            >

                            @error('password')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- REMEMBER ME --}}
                        <div class="mb-3 form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="remember"
                                id="remember"
                                {{ old('remember') ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="remember">
                                Ingat Saya
                            </label>
                        </div>

                        {{-- BUTTON LOGIN --}}
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                Login
                            </button>
                        </div>

                        {{-- LUPA PASSWORD --}}
                        @if (Route::has('password.request'))
                        <div class="text-center mb-3">
                            <a href="{{ route('password.request') }}" class="text-decoration-none">
                                Lupa Password?
                            </a>
                        </div>
                        @endif

                        <hr>

                        {{-- GOOGLE LOGIN --}}
                        <div class="d-grid mb-3">
                            <a href="{{ route('auth.google') }}"
                               class="btn btn-outline-danger rounded-pill d-flex align-items-center justify-content-center">
                                <img src="https://www.svgrepo.com/show/475656/google-color.svg"
                                     width="18" class="me-2">
                                Login dengan Google
                            </a>
                        </div>

                        {{-- REGISTER --}}
                        <p class="text-center mb-0">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="fw-bold text-decoration-none">
                                Daftar Sekarang
                            </a>
                        </p>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection