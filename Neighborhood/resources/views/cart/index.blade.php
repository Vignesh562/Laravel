@extends('layouts.app')

@section('content')
<style>
    .cart-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--dark-charcoal);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-title i {
        color: var(--primary-cyan);
    }

    .cart-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2rem;
    }

    .cart-items {
        background: white;
        border-radius: var(--radius-xl);
        padding: 2rem;
        box-shadow: var(--shadow-md);
    }

    .cart-item {
        display: grid;
        grid-template-columns: 120px 1fr auto;
        gap: 1.5rem;
        padding: 1.5rem;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-lg);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .cart-item:hover {
        border-color: var(--primary-cyan);
        box-shadow: var(--shadow-md);
    }

    .cart-item-image {
        width: 120px;
        height: 120px;
        background: var(--gray-100);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .cart-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cart-item-image i {
        font-size: 3rem;
        color: var(--gray-300);
    }

    .cart-item-details {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .cart-item-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--dark-charcoal);
        margin-bottom: 0.5rem;
    }

    .cart-item-seller {
        font-size: 0.875rem;
        color: var(--gray-600);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .cart-item-price {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary-cyan);
    }

    .cart-item-actions {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-end;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--gray-100);
        padding: 0.5rem;
        border-radius: var(--radius-lg);
    }

    .quantity-control button {
        width: 35px;
        height: 35px;
        border: none;
        background: white;
        border-radius: var(--radius-md);
        cursor: pointer;
        font-weight: 700;
        color: var(--primary-cyan);
        transition: all 0.3s ease;
    }

    .quantity-control button:hover {
        background: var(--primary-cyan);
        color: white;
    }

    .quantity-control input {
        width: 50px;
        text-align: center;
        border: none;
        background: white;
        padding: 0.5rem;
        border-radius: var(--radius-md);
        font-weight: 600;
    }

    .remove-btn {
        background: none;
        border: none;
        color: var(--coral-red);
        cursor: pointer;
        font-size: 1.25rem;
        padding: 0.5rem;
        transition: all 0.3s ease;
    }

    .remove-btn:hover {
        transform: scale(1.2);
    }

    .cart-summary {
        position: sticky;
        top: 100px;
        background: white;
        border-radius: var(--radius-xl);
        padding: 2rem;
        box-shadow: var(--shadow-md);
        height: fit-content;
    }

    .summary-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--dark-charcoal);
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--gray-200);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 1rem;
        color: var(--gray-700);
    }

    .summary-row.total {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--dark-charcoal);
        padding-top: 1rem;
        border-top: 2px solid var(--gray-200);
        margin-top: 1rem;
    }

    .summary-row.total .amount {
        color: var(--primary-cyan);
    }

    .checkout-btn {
        width: 100%;
        padding: 1.25rem;
        font-size: 1.125rem;
        margin-top: 1.5rem;
    }

    .continue-shopping {
        width: 100%;
        text-align: center;
        margin-top: 1rem;
    }

    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
    }

    .empty-cart i {
        font-size: 6rem;
        color: var(--gray-300);
        margin-bottom: 1.5rem;
    }

    .empty-cart h3 {
        font-size: 1.75rem;
        color: var(--gray-700);
        margin-bottom: 1rem;
    }

    .empty-cart p {
        color: var(--gray-500);
        margin-bottom: 2rem;
    }

    @media (max-width: 1024px) {
        .cart-grid {
            grid-template-columns: 1fr;
        }

        .cart-summary {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .cart-item {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .cart-item-actions {
            align-items: center;
        }
    }
</style>

<div class="cart-container">
    <h1 class="page-title fade-in">
        <i class="fas fa-shopping-cart"></i>
        Shopping Cart
    </h1>

    @if(count($cart ?? []) > 0)
        <div class="cart-grid">
            <!-- Cart Items -->
            <div class="cart-items slide-in-left">
                @foreach($cart as $id => $item)
                    <div class="cart-item scale-in delay-{{ $loop->index * 100 }}">
                        <div class="cart-item-image">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                            @else
                                <i class="fas fa-image"></i>
                            @endif
                        </div>

                        <div class="cart-item-details">
                            <div>
                                <div class="cart-item-name">{{ $item['name'] }}</div>
                                <div class="cart-item-seller">
                                    <i class="fas fa-store"></i>
                                    {{ $item['seller_name'] ?? 'Unknown Seller' }}
                                </div>
                            </div>
                            <div class="cart-item-price">₹{{ number_format($item['price'], 2) }}</div>
                        </div>

                        <div class="cart-item-actions">
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-btn" title="Remove item">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>

                            <form action="{{ route('cart.update', $id) }}" method="POST" id="update-form-{{ $id }}">
                                @csrf
                                @method('PUT')
                                <div class="quantity-control">
                                    <button type="button" onclick="updateQuantity({{ $id }}, -1, {{ $item['stock'] }})">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" name="quantity" id="quantity-{{ $id }}" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}" readonly>
                                    <button type="button" onclick="updateQuantity({{ $id }}, 1, {{ $item['stock'] }})">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Cart Summary -->
            <div class="cart-summary slide-in-right">
                <div class="summary-title">
                    <i class="fas fa-receipt"></i>
                    Order Summary
                </div>

                <div class="summary-row">
                    <span>Subtotal ({{ count($cart) }} items)</span>
                    <span class="amount">₹{{ number_format($total, 2) }}</span>
                </div>

                <div class="summary-row">
                    <span>Shipping</span>
                    <span class="amount">FREE</span>
                </div>

                <div class="summary-row total">
                    <span>Total</span>
                    <span class="amount">₹{{ number_format($total, 2) }}</span>
                </div>

                <a href="{{ route('checkout.index') }}" class="btn btn-primary checkout-btn">
                    <i class="fas fa-lock"></i>
                    Proceed to Checkout
                </a>

                <a href="{{ route('products.index') }}" class="btn btn-outline continue-shopping">
                    <i class="fas fa-arrow-left"></i>
                    Continue Shopping
                </a>
            </div>
        </div>
    @else
        <div class="empty-cart fade-in">
            <i class="fas fa-shopping-cart"></i>
            <h3>Your cart is empty</h3>
            <p>Looks like you haven't added anything to your cart yet. Start shopping now!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag"></i>
                Start Shopping
            </a>
        </div>
    @endif
</div>

<script>
    function updateQuantity(id, change, max) {
        const input = document.getElementById('quantity-' + id);
        const currentValue = parseInt(input.value);
        const newValue = currentValue + change;

        if (newValue >= 1 && newValue <= max) {
            input.value = newValue;
            document.getElementById('update-form-' + id).submit();
        }
    }
</script>
@endsection
