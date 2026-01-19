@extends('layouts.app')

@section('content')
<style>
    .product-detail-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    .product-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        background: white;
        border-radius: var(--radius-2xl);
        padding: 3rem;
        box-shadow: var(--shadow-xl);
        margin-bottom: 3rem;
    }

    .product-image-section {
        position: sticky;
        top: 100px;
        height: fit-content;
    }

    .main-image {
        width: 100%;
        height: 500px;
        background: var(--gray-100);
        border-radius: var(--radius-xl);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .main-image i {
        font-size: 6rem;
        color: var(--gray-300);
    }

    .product-info-section h1 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--dark-charcoal);
        margin-bottom: 1rem;
    }

    .product-meta {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid var(--gray-200);
    }

    .product-category-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, var(--primary-cyan), var(--primary-turquoise));
        color: white;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-full);
        font-weight: 600;
    }

    .product-seller-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.5rem;
        background: var(--gray-50);
        border-radius: var(--radius-lg);
    }

    .product-seller-info i {
        font-size: 1.5rem;
        color: var(--primary-cyan);
    }

    .product-price-section {
        background: linear-gradient(135deg, rgba(19, 200, 236, 0.1), rgba(19, 236, 200, 0.1));
        padding: 2rem;
        border-radius: var(--radius-xl);
        margin-bottom: 2rem;
    }

    .product-price {
        font-size: 3rem;
        font-weight: 900;
        color: var(--primary-cyan);
        margin-bottom: 0.5rem;
    }

    .product-stock {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--success);
        font-weight: 600;
    }

    .product-stock.out-of-stock {
        color: var(--coral-red);
    }

    .product-description {
        margin-bottom: 2rem;
    }

    .product-description h3 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--dark-charcoal);
    }

    .product-description p {
        color: var(--gray-700);
        line-height: 1.8;
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .quantity-selector label {
        font-weight: 600;
        color: var(--gray-700);
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--gray-100);
        padding: 0.5rem;
        border-radius: var(--radius-lg);
    }

    .quantity-controls button {
        width: 40px;
        height: 40px;
        border: none;
        background: white;
        border-radius: var(--radius-md);
        cursor: pointer;
        font-weight: 700;
        color: var(--primary-cyan);
        transition: all 0.3s ease;
    }

    .quantity-controls button:hover {
        background: var(--primary-cyan);
        color: white;
    }

    .quantity-controls input {
        width: 60px;
        text-align: center;
        border: none;
        background: white;
        padding: 0.5rem;
        border-radius: var(--radius-md);
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
    }

    .action-buttons .btn {
        flex: 1;
        padding: 1rem 2rem;
        font-size: 1.125rem;
    }

    /* Related Products */
    .related-products {
        margin-top: 4rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--dark-charcoal);
        margin-bottom: 2rem;
        text-align: center;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
    }

    .related-product-card {
        background: white;
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
    }

    .related-product-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
    }

    .related-product-image {
        width: 100%;
        height: 200px;
        background: var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .related-product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .related-product-image i {
        font-size: 3rem;
        color: var(--gray-300);
    }

    .related-product-info {
        padding: 1.5rem;
    }

    .related-product-name {
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--dark-charcoal);
    }

    .related-product-price {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary-cyan);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .product-detail-grid {
            grid-template-columns: 1fr;
        }

        .product-image-section {
            position: static;
        }

        .related-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .product-info-section h1 {
            font-size: 2rem;
        }

        .product-price {
            font-size: 2.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .related-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="product-detail-container">
    <!-- Product Detail -->
    <div class="product-detail-grid fade-in">
        <!-- Image Section -->
        <div class="product-image-section slide-in-left">
            <div class="main-image">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <i class="fas fa-image"></i>
                @endif
            </div>
        </div>

        <!-- Info Section -->
        <div class="product-info-section slide-in-right">
            <h1>{{ $product->name }}</h1>

            <div class="product-meta">
                <span class="product-category-badge">
                    <i class="fas fa-tag"></i>
                    {{ $product->category->name ?? 'Uncategorized' }}
                </span>
                <div class="product-seller-info">
                    <i class="fas fa-store"></i>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--gray-500);">Sold by</div>
                        <div style="font-weight: 700; color: var(--dark-charcoal);">{{ $product->seller->shop_name ?? 'Unknown Seller' }}</div>
                    </div>
                </div>
            </div>

            <div class="product-price-section">
                <div class="product-price">₹{{ number_format($product->price, 2) }}</div>
                <div class="product-stock {{ $product->stock > 0 ? '' : 'out-of-stock' }}">
                    <i class="fas fa-{{ $product->stock > 0 ? 'check-circle' : 'times-circle' }}"></i>
                    @if($product->stock > 0)
                        In Stock ({{ $product->stock }} available)
                    @else
                        Out of Stock
                    @endif
                </div>
            </div>

            <div class="product-description">
                <h3><i class="fas fa-info-circle"></i> Product Description</h3>
                <p>{{ $product->description }}</p>
            </div>

            @if($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="quantity-selector">
                        <label><i class="fas fa-shopping-basket"></i> Quantity:</label>
                        <div class="quantity-controls">
                            <button type="button" onclick="decreaseQuantity()">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" readonly>
                            <button type="button" onclick="increaseQuantity({{ $product->stock }})">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="action-buttons">
                        @auth
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-cart-plus"></i>
                                Add to Cart
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline">
                                <i class="fas fa-arrow-left"></i>
                                Continue Shopping
                            </a>
                        @else
                            <a href="{{ route('user.login') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i>
                                Login to Purchase
                            </a>
                        @endauth
                    </div>
                </form>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    This product is currently out of stock. Please check back later.
                </div>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts && $relatedProducts->count() > 0)
        <div class="related-products fade-in">
            <h2 class="section-title">
                <i class="fas fa-layer-group"></i>
                Related Products
            </h2>
            <div class="related-grid">
                @foreach($relatedProducts as $index => $relatedProduct)
                    <a href="{{ route('products.show', $relatedProduct) }}" class="related-product-card scale-in delay-{{ $index * 100 }}">
                        <div class="related-product-image">
                            @if($relatedProduct->image)
                                <img src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}">
                            @else
                                <i class="fas fa-image"></i>
                            @endif
                        </div>
                        <div class="related-product-info">
                            <div class="related-product-name">{{ Str::limit($relatedProduct->name, 50) }}</div>
                            <div class="related-product-price">₹{{ number_format($relatedProduct->price, 2) }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    function increaseQuantity(max) {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        if (currentValue < max) {
            input.value = currentValue + 1;
        }
    }

    function decreaseQuantity() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }
</script>
@endsection
