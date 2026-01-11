<style>
.product-card {
    background: white;
    border-radius: 16px;
    padding: 14px;
    transition: all .25s ease;
    border: 1px solid #e5e7eb;
}
.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0,0,0,.08);
}
.product-card:active {
    transform: scale(.98);
}
.product-card img {
    border-radius: 12px;
    transition: .3s;
}
.product-card:hover img {
    transform: scale(1.05);
}
.btn-cart {
    background: #2563eb;
    color: white;
    border-radius: 10px;
    padding: 10px;
    font-weight: 600;
    transition: all .25s ease;
}
.btn-cart:hover {
    background: #1e40af;
    box-shadow: 0 8px 20px rgba(37,99,235,.4);
}
.btn-cart:active {
    transform: scale(.95);
}
.wishlist {
    position: absolute;
    top: 12px;
    right: 12px;
    background: white;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: .3s;
}
.wishlist:hover {
    background: #fee2e2;
    color: #ef4444;
}
.wishlist:active {
    transform: scale(.9);
}
</style>
<div class="product-card h-100 overflow-hidden">

    {{-- Product Image --}}
    <div class="position-relative bg-light">
        <a href="{{ route('catalog.show', $product->slug) }}">
            <img src="{{ $product->image_url }}"
                 class="card-img-top"
                 alt="{{ $product->name }}"
                 style="height: 200px; object-fit: cover;">
        </a>

        {{-- Badge Diskon --}}
        @if($product->has_discount)
            <span class="position-absolute top-0 start-0 m-2 badge bg-danger rounded-pill px-3 py-2">
                -{{ $product->discount_percentage }}%
            </span>
        @endif

        {{-- Wishlist Button --}}
        @auth
        <button onclick="toggleWishlist({{ $product->id }})"
                class="position-absolute top-0 end-0 m-2 btn btn-light btn-sm rounded-circle shadow-sm wishlist-btn-{{ $product->id }}">
            <i class="bi {{ Auth::check() && Auth::user()->hasInWishlist($product)
                ? 'bi-heart-fill text-danger'
                : 'bi-heart text-secondary' }} fs-6"></i>
        </button>
        @endauth
    </div>

    {{-- Card Body --}}
    <div class="card-body d-flex flex-column p-3">

        {{-- Category --}}
        <span class="badge bg-soft-primary text-primary mb-2 align-self-start">
            {{ $product->category->name }}
        </span>

        {{-- Product Name --}}
        <h6 class="fw-semibold mb-2">
            <a href="{{ route('catalog.show', $product->slug) }}"
               class="text-decoration-none text-dark stretched-link">
                {{ Str::limit($product->name, 40) }}
            </a>
        </h6>

        {{-- Price --}}
        <div class="mt-auto">
            @if($product->has_discount)
                <small class="text-muted text-decoration-line-through d-block">
                    {{ $product->formatted_original_price }}
                </small>
            @endif
            <div class="fw-bold text-primary fs-6">
                {{ $product->formatted_price }}
            </div>
        </div>

        {{-- Stock Info --}}
        @if($product->stock <= 5 && $product->stock > 0)
            <small class="text-warning mt-2">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                Stok tinggal {{ $product->stock }}
            </small>
        @elseif($product->stock == 0)
            <small class="text-danger mt-2">
                <i class="bi bi-x-circle-fill me-1"></i>
                Stok Habis
            </small>
        @endif
    </div>

    {{-- Card Footer --}}
    <div class="card-footer bg-white border-0 p-3 pt-0">
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">

            <button type="submit"
                    class="btn btn-cart w-100"
                    @if($product->stock == 0) disabled @endif>
                <i class="bi bi-cart-plus me-1"></i>
                {{ $product->stock == 0 ? 'Stok Habis' : 'Tambah Keranjang' }}
            </button>
        </form>
    </div>

</div>