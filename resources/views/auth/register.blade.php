@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">

        <div class="col-md-6 col-lg-5">

            <div class="card shadow border-0 rounded-4 overflow-hidden">

                {{-- ===== HEADER + LOGO ===== --}}
                <div class="bg-primary text-white text-center p-4">
                    
                    <h4 class="fw-bold mb-1">Buat Akun Baru ✨</h4>
                    <p class="mb-0 opacity-75">
                        Bergabung bersama <strong>TokoSnack</strong>
                    </p>
                </div>

                {{-- ===== BODY ===== --}}
                <div class="card-body p-4">

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- NAMA --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Nama Lengkap
                            </label>
                            <input
                                id="name"
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                placeholder="Nama lengkap"
                            >

                            @error('name')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

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

                        {{-- KONFIRMASI PASSWORD --}}
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-semibold">
                                Konfirmasi Password
                            </label>
                            <input
                                id="password-confirm"
                                type="password"
                                class="form-control"
                                name="password_confirmation"
                                required
                                placeholder="••••••••"
                            >
                        </div>

                        {{-- BUTTON REGISTER --}}
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                Daftar
                            </button>
                        </div>

                        {{-- LINK LOGIN --}}
                        <p class="text-center mb-0">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="fw-bold text-decoration-none">
                                Login Sekarang
                            </a>
                        </p>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection