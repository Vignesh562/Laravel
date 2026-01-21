@extends('layouts.app')

@section('content')
<style>
    .order-container {
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

    .order-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2rem;
    }

    .order-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 2rem;
        box-shadow: var(--shadow-md);
    }

    .section-title {
        font-size: 1.25rem;
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

    .order-status-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: linear-gradient(135deg, rgba(19, 200, 236, 0.1), rgba(19, 236, 200, 0.1));
        border-radius: var(--radius-lg);
        margin-bottom: 2rem;
    }

    .order-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--dark-charcoal);
    }

    .order-date {
        color: var(--gray-600);
        margin-top: 0.25rem;
    }

    .order-items {
        margin-bottom: 2rem;
    }

    .order-item {
        display: flex;
        gap: 1.5rem;
        padding: 1.5rem;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-lg);
        margin-bottom: 1rem;
    }

    .item-image {
        width: 100px;
        height: 100px;
        background: var(--gray-100);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: var(--radius-md);
    }

    .item-image i {
        font-size: 2rem;
        color: var(--gray-300);
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--dark-charcoal);
        margin-bottom: 0.5rem;
    }

    .item-seller {
        font-size: 0.875rem;
        color: var(--gray-600);
        margin-bottom: 0.5rem;
    }

    .item-qty {
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    .item-price {
        text-align: right;
    }

    .item-unit-price {
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    .item-total-price {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary-cyan);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--gray-200);
    }

    .info-label {
        color: var(--gray-600);
        font-weight: 600;
    }

    .info-value {
        color: var(--dark-charcoal);
        font-weight: 600;
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

    @media (max-width: 1024px) {
        .order-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .order-item {
            flex-direction: column;
            text-align: center;
        }

        .item-price {
            text-align: center;
        }
    }
</style>

<div class="order-container">
    <h1 class="page-title fade-in">
        <i class="fas fa-receipt"></i>
        Order Details
    </h1>

    <div class="order-status-header fade-in">
        <div>
            <div class="order-number">
                <i class="fas fa-hashtag"></i>
                Order #{{ $order->id }}
            </div>
            <div class="order-date">
                <i class="fas fa-calendar"></i>
                Placed on {{ $order->created_at->format('M d, Y h:i A') }}
            </div>
        </div>
        <span class="order-status {{ $order->status }}">
            <i class="fas fa-{{ $order->status == 'delivered' ? 'check-circle' : ($order->status == 'cancelled' ? 'times-circle' : 'clock') }}"></i>
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <div class="order-grid">
        <!-- Order Items -->
        <div class="order-card slide-in-left">
            <div class="section-title">
                <i class="fas fa-box"></i>
                Order Items
            </div>

            <div class="order-items">
                @foreach($order->orderItems as $item)
                    <div class="order-item">
                        <div class="item-image">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}">
                            @else
                                <i class="fas fa-image"></i>
                            @endif
                        </div>

                        <div class="item-details">
                            <div class="item-name">{{ $item->product_name }}</div>
                            <div class="item-seller">
                                <i class="fas fa-store"></i>
                                Sold by: {{ $item->product->seller->shop_name ?? 'N/A' }}
                            </div>
                            <div class="item-qty">Quantity: {{ $item->quantity }}</div>
                        </div>

                        <div class="item-price">
                            <div class="item-unit-price">₹{{ number_format($item->price, 2) }} each</div>
                            <div class="item-total-price">₹{{ number_format($item->price * $item->quantity, 2) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Shipping Information -->
            <div class="section-title" style="margin-top: 2rem;">
                <i class="fas fa-shipping-fast"></i>
                Shipping Information
            </div>

            <div class="info-row">
                <span class="info-label">Name</span>
                <span class="info-value">{{ $order->shipping_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Phone</span>
                <span class="info-value">{{ $order->shipping_phone }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Address</span>
                <span class="info-value">{{ $order->shipping_address }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">City</span>
                <span class="info-value">{{ $order->shipping_city }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Postal Code</span>
                <span class="info-value">{{ $order->shipping_postal_code }}</span>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="order-card slide-in-right">
            <div class="section-title">
                <i class="fas fa-file-invoice-dollar"></i>
                Order Summary
            </div>

            <div class="summary-row">
                <span>Subtotal ({{ $order->orderItems->count() }} items)</span>
                <span class="amount">₹{{ number_format($order->total_amount, 2) }}</span>
            </div>

            <div class="summary-row">
                <span>Shipping</span>
                <span class="amount">FREE</span>
            </div>

            <div class="summary-row total">
                <span>Total</span>
                <span class="amount">₹{{ number_format($order->total_amount, 2) }}</span>
            </div>

            <div style="margin-top: 2rem; padding-top: 2rem; border-top: 2px solid var(--gray-200);">
                <div class="info-row">
                    <span class="info-label">Payment Method</span>
                    <span class="info-value">{{ ucfirst($order->payment_method) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Status</span>
                    <span class="info-value">
                        @if($order->payment_status == 'paid')
                            <span class="badge badge-success">Paid</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </span>
                </div>
            </div>

            <a href="{{ route('orders.index') }}" class="btn btn-outline" style="width: 100%; margin-top: 2rem;">
                <i class="fas fa-arrow-left"></i>
                Back to Orders
            </a>
        </div>
    </div>
</div>
@endsection
