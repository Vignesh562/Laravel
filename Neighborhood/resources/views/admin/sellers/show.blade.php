@extends('layouts.admin')

@section('page-title', 'Seller Details')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.sellers.index') }}" style="color: #667eea; text-decoration: none; font-weight: 600;">
        ← Back to Sellers
    </a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <!-- Seller Information -->
    <div class="card">
        <h2 style="font-size: 1.75rem; font-weight: 800; color: #1e293b; margin-bottom: 2rem;">
            {{ $seller->shop_name }}
        </h2>

        <div style="display: grid; gap: 1.5rem;">
            <div>
                <label style="display: block; color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Owner Name</label>
                <p style="font-size: 1.125rem; font-weight: 600; color: #1e293b;">{{ $seller->user->name }}</p>
            </div>

            <div>
                <label style="display: block; color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Email</label>
                <p style="font-size: 1rem; color: #475569;">{{ $seller->user->email }}</p>
            </div>

            <div>
                <label style="display: block; color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Phone</label>
                <p style="font-size: 1rem; color: #475569;">{{ $seller->user->phone ?? 'Not provided' }}</p>
            </div>

            @if($seller->shop_description)
            <div>
                <label style="display: block; color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Shop Description</label>
                <p style="font-size: 1rem; color: #475569; line-height: 1.6;">{{ $seller->shop_description }}</p>
            </div>
            @endif

            <div>
                <label style="display: block; color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Registration Date</label>
                <p style="font-size: 1rem; color: #475569;">{{ $seller->created_at->format('F d, Y') }}</p>
            </div>

            <div>
                <label style="display: block; color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Current Status</label>
                <p>
                    @if($seller->status === 'approved')
                        <span style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 0.5rem 1.25rem; border-radius: 20px; font-weight: 700; font-size: 1rem;">
                            ✓ Approved
                        </span>
                    @elseif($seller->status === 'pending')
                        <span style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 0.5rem 1.25rem; border-radius: 20px; font-weight: 700; font-size: 1rem;">
                            ⏳ Pending Approval
                        </span>
                    @else
                        <span style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 0.5rem 1.25rem; border-radius: 20px; font-weight: 700; font-size: 1rem;">
                            ✗ Rejected
                        </span>
                    @endif
                </p>
            </div>
        </div>

        @if($seller->status === 'pending')
        <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 2px solid #e2e8f0;">
            <form action="{{ route('admin.sellers.approve', $seller) }}" method="POST" style="flex: 1;">
                @csrf
                <button type="submit" class="btn" style="width: 100%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);">
                    ✓ Approve Seller
                </button>
            </form>
            <form action="{{ route('admin.sellers.reject', $seller) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Are you sure you want to reject this seller?');">
                @csrf
                <button type="submit" class="btn btn-danger" style="width: 100%;">
                    ✗ Reject Application
                </button>
            </form>
        </div>
        @endif
    </div>

    <!-- Statistics -->
    <div>
        <div class="card" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b;">Statistics</h3>
            
            <div style="display: grid; gap: 1rem;">
                <div style="padding: 1rem; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 12px;">
                    <p style="color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem;">Total Products</p>
                    <p style="font-size: 2rem; font-weight: 800; color: #1e293b;">{{ $seller->products->count() }}</p>
                </div>

                <div style="padding: 1rem; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 12px;">
                    <p style="color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem;">Active Products</p>
                    <p style="font-size: 2rem; font-weight: 800; color: #10b981;">{{ $seller->products->where('status', 'active')->count() }}</p>
                </div>

                <div style="padding: 1rem; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 12px;">
                    <p style="color: #64748b; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem;">Pending Products</p>
                    <p style="font-size: 2rem; font-weight: 800; color: #f59e0b;">{{ $seller->products->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products List -->
@if($seller->products->count() > 0)
<div class="card" style="margin-top: 2rem;">
    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b;">Products</h3>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
        @foreach($seller->products as $product)
        <div style="border: 2px solid #e2e8f0; border-radius: 12px; overflow: hidden; transition: all 0.3s;" onmouseover="this.style.borderColor='#667eea'" onmouseout="this.style.borderColor='#e2e8f0'">
            <div style="height: 150px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center;">
                @if($product->main_image)
                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <span style="font-size: 3rem;">📦</span>
                @endif
            </div>
            <div style="padding: 1rem;">
                <h4 style="font-weight: 700; margin-bottom: 0.5rem; color: #1e293b;">{{ $product->name }}</h4>
                <p style="font-size: 1.25rem; font-weight: 800; color: #667eea; margin: 0.5rem 0;">₹{{ number_format($product->price, 2) }}</p>
                <p style="font-size: 0.875rem; color: #64748b;">Stock: {{ $product->stock }}</p>
                <p style="margin-top: 0.5rem;">
                    @if($product->status === 'active')
                        <span style="background: #10b981; color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">Active</span>
                    @elseif($product->status === 'pending')
                        <span style="background: #f59e0b; color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">Pending</span>
                    @else
                        <span style="background: #64748b; color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">Inactive</span>
                    @endif
                </p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection
