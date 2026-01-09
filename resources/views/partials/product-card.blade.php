<div class="card product-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">

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
                    class="btn btn-primary btn-sm w-100 rounded-pill"
                    @if($product->stock == 0) disabled @endif>
                <i class="bi bi-cart-plus me-1"></i>
                {{ $product->stock == 0 ? 'Stok Habis' : 'Tambah Keranjang' }}
            </button>
        </form>
    </div>

</div>