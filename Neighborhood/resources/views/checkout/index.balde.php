@extends('layouts.app')

@section('content')
<style>
    .checkout-container {
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

    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2rem;
    }

    .checkout-form {
        background: white;
        border-radius: var(--radius-xl);
        padding: 2.5rem;
        box-shadow: var(--shadow-md);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark-charcoal);
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--gray-200);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: var(--primary-cyan);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-grid.full {
        grid-template-columns: 1fr;
    }

    .order-summary-sidebar {
        position: sticky;
        top: 100px;
        height: fit-content;
    }

    .summary-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 2rem;
        box-shadow: var(--shadow-md);
        margin-bottom: 1.5rem;
    }

    .summary-items {
        max-height: 400px;
        overflow-y: auto;
        margin-bottom: 1.5rem;
    }

    .summary-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-md);
        margin-bottom: 1rem;
    }

    .summary-item-image {
        width: 60px;
        height: 60px;
        background: var(--gray-100);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .summary-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: var(--radius-md);
    }

    .summary-item-image i {
        font-size: 1.5rem;
        color: var(--gray-300);
    }

    .summary-item-details {
        flex: 1;
    }

    .summary-item-name {
        font-weight: 600;
        color: var(--dark-charcoal);
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
    }

    .summary-item-qty {
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    .summary-item-price {
        font-weight: 700;
        color: var(--primary-cyan);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
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

    .place-order-btn {
        width: 100%;
        padding: 1.25rem;
        font-size: 1.125rem;
    }

    .payment-methods {
        display: grid;
        gap: 1rem;
    }

    .payment-option {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--radius-lg);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-option:hover {
        border-color: var(--primary-cyan);
        background: rgba(19, 200, 236, 0.05);
    }

    .payment-option input[type="radio"] {
        width: 20px;
        height: 20px;
        accent-color: var(--primary-cyan);
    }

    .payment-option.selected {
        border-color: var(--primary-cyan);
        background: rgba(19, 200, 236, 0.1);
    }

    .payment-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary-cyan), var(--primary-turquoise));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }

    .payment-details {
        flex: 1;
    }

    .payment-name {
        font-weight: 700;
        color: var(--dark-charcoal);
        margin-bottom: 0.25rem;
    }

    .payment-description {
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    @media (max-width: 1024px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }

        .order-summary-sidebar {
            position: static;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="checkout-container">
    <h1 class="page-title fade-in">
        <i class="fas fa-lock"></i>
        Secure Checkout
    </h1>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="checkout-grid">
            <!-- Checkout Form -->
            <div class="checkout-form slide-in-left">
                <!-- Shipping Information -->
                <div class="section-title">
                    <i class="fas fa-shipping-fast"></i>
                    Shipping Information
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="shipping_name" class="form-control" required value="{{ old('shipping_name', Auth::user()->name) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone Number *</label>
                        <input type="tel" name="shipping_phone" class="form-control" required value="{{ old('shipping_phone', Auth::user()->phone) }}">
                    </div>
                </div>

                <div class="form-grid full">
                    <div class="form-group">
                        <label class="form-label">Address *</label>
                        <input type="text" name="shipping_address" class="form-control" required value="{{ old('shipping_address') }}">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">City *</label>
                        <input type="text" name="shipping_city" class="form-control" required value="{{ old('shipping_city') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Postal Code *</label>
                        <input type="text" name="shipping_postal_code" class="form-control" required value="{{ old('shipping_postal_code') }}">
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="section-title" style="margin-top: 2rem;">
                    <i class="fas fa-credit-card"></i>
                    Payment Method
                </div>

                <div class="payment-methods">
                    <label class="payment-option selected">
                        <input type="radio" name="payment_method" value="cod" checked>
                        <div class="payment-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="payment-details">
                            <div class="payment-name">Cash on Delivery</div>
                            <div class="payment-description">Pay when you receive your order</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="order-summary-sidebar slide-in-right">
                <div class="summary-card">
                    <div class="section-title">
                        <i class="fas fa-receipt"></i>
                        Order Summary
                    </div>

                    <div class="summary-items">
                        @foreach($cart as $id => $item)
                            <div class="summary-item">
                                <div class="summary-item-image">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                                    @else
                                        <i class="fas fa-image"></i>
                                    @endif
                                </div>
                                <div class="summary-item-details">
                                    <div class="summary-item-name">{{ $item['name'] }}</div>
                                    <div class="summary-item-qty">Qty: {{ $item['quantity'] }}</div>
                                </div>
                                <div class="summary-item-price">
                                    ₹{{ number_format($item['price'] * $item['quantity'], 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="summary-row">
                        <span>Subtotal</span>
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

                    <button type="submit" class="btn btn-primary place-order-btn">
                        <i class="fas fa-check-circle"></i>
                        Place Order
                    </button>

                    <div style="text-align: center; margin-top: 1rem;">
                        <a href="{{ route('cart.index') }}" style="color: var(--gray-600); font-size: 0.875rem;">
                            <i class="fas fa-arrow-left"></i>
                            Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Payment method selection
    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            this.querySelector('input[type="radio"]').checked = true;
        });
    });
</script>
@endsection
