@extends('layouts.app')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary-cyan), var(--primary-turquoise));
        color: white;
        padding: 3rem 0;
        margin-bottom: 3rem;
        text-align: center;
    }

    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: white;
    }

    .page-header p {
        font-size: 1.125rem;
        opacity: 0.95;
    }

    .products-container {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 2rem;
        margin-bottom: 3rem;
    }

    /* Sidebar Filters */
    .filters-sidebar {
        position: sticky;
        top: 100px;
        height: fit-content;
    }

    .filter-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        margin-bottom: 1.5rem;
    }

    .filter-card h3 {
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--dark-charcoal);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-card h3 i {
        color: var(--primary-cyan);
    }

    .search-box {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .search-box input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 3rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--radius-lg);
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--primary-cyan);
        box-shadow: 0 0 0 3px rgba(19, 200, 236, 0.1);
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
    }

    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .category-list li {
        margin-bottom: 0.75rem;
    }

    .category-list a {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem;
        border-radius: var(--radius-md);
        color: var(--gray-700);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .category-list a:hover,
    .category-list a.active {
        background: linear-gradient(135deg, var(--primary-cyan), var(--primary-turquoise));
        color: white;
    }

    .category-count {
        background: var(--gray-200);
        color: var(--gray-700);
        padding: 0.25rem 0.5rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
    }

    .category-list a:hover .category-count,
    .category-list a.active .category-count {
        background: rgba(255, 255, 255, 0.3);
        color: white;
    }

    /* Products Grid */
    .products-main {
        min-height: 400px;
    }

    .products-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .products-count {
        font-size: 1.125rem;
        color: var(--gray-600);
    }

    .products-count strong {
        color: var(--primary-cyan);
        font-weight: 700;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .product-card {
        background: white;
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-2xl);
    }

    .product-image {
        width: 100%;
        height: 250px;
        background: var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.1);
    }

    .product-image i {
        font-size: 4rem;
        color: var(--gray-300);
    }

    .product-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--gold-star);
        color: var(--dark-charcoal);
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 700;
    }

    .product-info {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-category {
        font-size: 0.75rem;
        color: var(--primary-cyan);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .product-name {
        font-weight: 700;
        font-size: 1.125rem;
        margin-bottom: 0.75rem;
        color: var(--dark-charcoal);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-description {
        font-size: 0.875rem;
        color: var(--gray-600);
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid var(--gray-200);
    }

    .product-price {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary-cyan);
    }

    .product-seller {
        font-size: 0.875rem;
        color: var(--gray-600);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .add-to-cart-btn {
        width: 100%;
        margin-top: 1rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
    }

    .empty-state i {
        font-size: 5rem;
        color: var(--gray-300);
        margin-bottom: 1.5rem;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--gray-500);
        margin-bottom: 2rem;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 3rem;
    }

    .pagination a,
    .pagination span {
        padding: 0.75rem 1.25rem;
        background: white;
        border: 2px solid var(--gray-300);
        border-radius: var(--radius-md);
        color: var(--gray-700);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        border-color: var(--primary-cyan);
        color: var(--primary-cyan);
        transform: translateY(-2px);
    }

    .pagination .active {
        background: linear-gradient(135deg, var(--primary-cyan), var(--primary-turquoise));
        border-color: var(--primary-cyan);
        color: white;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .products-container {
            grid-template-columns: 1fr;
        }

        .filters-sidebar {
            position: static;
        }

        .products-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: 1fr;
        }

        .page-header h1 {
            font-size: 2rem;
        }
    }
</style>

<!-- Page Header -->
<div class="page-header fade-in">
    <div class="container">
        <h1>
            <i class="fas fa-shopping-bag"></i>
            @if(isset($category))
                {{ $category->name }} Products
            @else
                All Products
            @endif
        </h1>
        <p>Discover amazing products from local sellers</p>
    </div>
</div>

<div class="container">
    <div class="products-container">
        <!-- Sidebar Filters -->
        <aside class="filters-sidebar slide-in-left">
            <!-- Search -->
            <div class="filter-card">
                <h3>
                    <i class="fas fa-search"></i>
                    Search Products
                </h3>
                <form action="{{ route('products.search') }}" method="GET">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="q" placeholder="Search products..." value="{{ request('q') }}">
                    </div>
                </form>
            </div>

            <!-- Categories -->
            <div class="filter-card">
                <h3>
                    <i class="fas fa-layer-group"></i>
                    Categories
                </h3>
                <ul class="category-list">
                    <li>
                        <a href="{{ route('products.index') }}" class="{{ !isset($category) ? 'active' : '' }}">
                            <span><i class="fas fa-th"></i> All Products</span>
                            <span class="category-count">{{ $products->total() }}</span>
                        </a>
                    </li>
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('products.category', $cat->slug) }}" 
                               class="{{ isset($category) && $category->id == $cat->id ? 'active' : '' }}">
                                <span><i class="fas fa-folder"></i> {{ $cat->name }}</span>
                                <span class="category-count">{{ $cat->products_count ?? 0 }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- Products Grid -->
        <main class="products-main">
            <div class="products-header slide-in-right">
                <div class="products-count">
                    Showing <strong>{{ $products->count() }}</strong> of <strong>{{ $products->total() }}</strong> products
                </div>
            </div>

            @if($products->count() > 0)
                <div class="products-grid">
                    @foreach($products as $index => $product)
                        <div class="product-card scale-in delay-{{ ($index % 3) * 100 }}">
                            <a href="{{ route('products.show', $product) }}" style="text-decoration: none; color: inherit;">
                                <div class="product-image">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    @else
                                        <i class="fas fa-image"></i>
                                    @endif
                                </div>
                                <div class="product-info">
                                    <div class="product-category">
                                        <i class="fas fa-tag"></i> {{ $product->category->name ?? 'Uncategorized' }}
                                    </div>
                                    <div class="product-name">{{ $product->name }}</div>
                                    <div class="product-description">{{ Str::limit($product->description, 100) }}</div>
                                    <div class="product-footer">
                                        <div>
                                            <div class="product-price">₹{{ number_format($product->price, 2) }}</div>
                                            <div class="product-seller">
                                                <i class="fas fa-store"></i>
                                                {{ $product->seller->shop_name ?? 'Unknown' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @auth
                                <div style="padding: 0 1.5rem 1.5rem;">
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary add-to-cart-btn">
                                            <i class="fas fa-cart-plus"></i>
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div style="padding: 0 1.5rem 1.5rem;">
                                    <a href="{{ route('user.login') }}" class="btn btn-outline add-to-cart-btn">
                                        <i class="fas fa-sign-in-alt"></i>
                                        Login to Purchase
                                    </a>
                                </div>
                            @endauth
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination fade-in">
                    {{ $products->links() }}
                </div>
            @else
                <div class="empty-state fade-in">
                    <i class="fas fa-box-open"></i>
                    <h3>No Products Found</h3>
                    <p>We couldn't find any products matching your criteria. Try adjusting your filters or search terms.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i>
                        View All Products
                    </a>
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
