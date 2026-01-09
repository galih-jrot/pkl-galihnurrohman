{{-- ================================================
 FILE: resources/views/partials/navbar.blade.php
 TEMA: Kantin Sekolah Kekinian (Blue Glass + Modern)
================================================ --}}

<style>
/* ===== NAVBAR KANTIN ===== */
.navbar-kantin {
    background: rgba(13,110,253,.85);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    box-shadow: 0 10px 30px rgba(13,110,253,.35);
}

/* brand */
.navbar-brand span {
    font-weight: 800;
    letter-spacing: .5px;
    color: #fff;
}

/* link */
.navbar-kantin .nav-link {
    color: rgba(255,255,255,.9);
    font-weight: 500;
    transition: all .25s ease;
}

.navbar-kantin .nav-link:hover {
    color: #ffffff;
    text-shadow: 0 0 8px rgba(255,255,255,.6);
}

/* icon */
.navbar-kantin .bi {
    color: #e0edff;
}

/* toggler */
.navbar-toggler {
    border: none;
}
.navbar-toggler-icon {
    filter: brightness(200%);
}

/* search */
.navbar-kantin .form-control {
    border: none;
    box-shadow: none;
}
.navbar-kantin .form-control:focus {
    box-shadow: none;
}

.navbar-kantin .btn-primary {
    background: linear-gradient(to right, #0a58ca, #2563eb);
    border: none;
}

/* badge */
.navbar .badge {
    font-size: .6rem;
}

/* dropdown */
.dropdown-menu {
    border-radius: 1.2rem;
    border: none;
    box-shadow: 0 18px 40px rgba(13,110,253,.35);
}

.dropdown-item:hover {
    background: #eaf2ff;
}

/* avatar */
.navbar img.rounded-circle {
    border: 2px solid #dbeafe;
}
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-kantin sticky-top">
    <div class="container">

        {{-- LOGO --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <i class="bi bi-basket-fill me-2 fs-4 text-white"></i>
            <span>TokoSnack</span>
        </a>

        {{-- TOGGLER --}}
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">

            {{-- SEARCH --}}
            <form class="d-flex mx-auto my-3 my-lg-0"
                  style="max-width: 420px; width: 100%;"
                  action="{{ route('catalog.index') }}"
                  method="GET">
                <div class="input-group">
                    <input type="text"
                           name="q"
                           class="form-control rounded-start-pill"
                           placeholder="Cari jajanan favorit..."
                           value="{{ request('q') }}">
                    <button class="btn btn-primary rounded-end-pill" type="submit">
                        <i class="bi bi-search text-white"></i>
                    </button>
                </div>
            </form>

            {{-- MENU KANAN --}}
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('catalog.index') }}">
                        <i class="bi bi-grid me-1"></i> Katalog
                    </a>
                </li>

                @auth
                    {{-- WISHLIST --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('wishlist.index') }}">
                            <i class="bi bi-heart fs-5"></i>
                            @if(auth()->user()->wishlists()->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ auth()->user()->wishlists()->count() }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- CART --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 fs-5"></i>
                            @php
                                $cartCount = auth()->user()->cart?->items()->count() ?? 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light text-primary">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- USER --}}
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center"
                           href="#"
                           data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}"
                                 class="rounded-circle me-2"
                                 width="32" height="32">
                            <span class="d-none d-lg-inline fw-semibold text-white">
                                {{ auth()->user()->name }}
                            </span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i> Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="bi bi-bag me-2"></i> Pesanan Saya
                                </a>
                            </li>

                            @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-primary" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i> Admin Panel
                                    </a>
                                </li>
                            @endif

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                @else
                    {{-- GUEST --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm ms-2 rounded-pill text-primary fw-semibold"
                           href="{{ route('register') }}">
                            Daftar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>