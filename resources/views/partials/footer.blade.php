{{-- ================================================
 FILE: resources/views/partials/footer.blade.php
 TEMA: Kantin Sekolah Kekinian - SAMA DENGAN NAVBAR
================================================ --}}

<style>
/* ===== FOOTER KANTIN ===== */
.footer-kantin {
    background: linear-gradient(90deg, #0d6efd, #2563eb); /* SAMA NAVBAR */
    color: #ffffff;
    position: relative;
}

/* link */
.footer-kantin a {
    color: rgba(255,255,255,.9);
    text-decoration: none;
    transition: .25s;
}

.footer-kantin a:hover {
    color: #ffffff;
    padding-left: 4px;
}

/* social icon */
.footer-kantin .social-icon {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,.2);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: .3s;
}

.footer-kantin .social-icon i {
    font-size: 1.1rem;
}

.footer-kantin .social-icon:hover {
    background: #ffffff;
    color: #0d6efd;
    transform: translateY(-4px);
}

/* footer bottom */
.footer-bottom {
    border-top: 1px solid rgba(255,255,255,.25);
}

/* icon */
.footer-kantin .bi {
    color: #dbeafe;
}
</style>

<footer class="footer-kantin pt-5 pb-3 mt-0">
    <div class="container">

        <div class="row g-4">
            {{-- BRAND --}}
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-basket-fill me-2"></i>
                    TokoSnack
                </h5>
                <p class="opacity-75">
                    Kantin online sekolah kekinian.
                    Jajanan favorit siswa, harga pelajar, belanja makin gampang.
                </p>

                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-tiktok"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            {{-- MENU --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-semibold mb-3">Menu</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="mb-2"><a href="{{ route('catalog.index') }}">Katalog</a></li>
                    <li class="mb-2"><a href="#">Promo</a></li>
                </ul>
            </div>

            {{-- BANTUAN --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-semibold mb-3">Bantuan</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#">Cara Pesan</a></li>
                    <li class="mb-2"><a href="#">FAQ</a></li>
                    <li class="mb-2"><a href="#">Kebijakan</a></li>
                </ul>
            </div>

            {{-- KONTAK --}}
            <div class="col-lg-4 col-md-6">
                <h6 class="fw-semibold mb-3">Kontak Kantin</h6>
                <ul class="list-unstyled opacity-75">
                    <li class="mb-2">
                        <i class="bi bi-geo-alt me-2"></i>
                        Lingkungan Sekolah
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-clock me-2"></i>
                        Senin – Jumat, Jam Istirahat
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-whatsapp me-2"></i>
                        08xxxxxxxx
                    </li>
                </ul>
            </div>
        </div>

        {{-- FOOTER BOTTOM --}}
        <div class="row footer-bottom mt-4 pt-3 align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <small class="opacity-75">
                    &copy; {{ date('Y') }} TokoSnack Kantin Sekolah
                </small>
            </div>
            <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                <small class="opacity-75">
                    Dibuat oleh Siswa • Laravel Project
                </small>
            </div>
        </div>

    </div>
</footer>