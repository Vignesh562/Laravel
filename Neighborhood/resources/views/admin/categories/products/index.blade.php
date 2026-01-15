@extends('layouts.admin')

@section('page-title', 'Product Moderation')

@section('content')

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <!-- Approved -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden flex items-center justify-between group">
        <div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Approved</p>
            <h3 class="text-3xl font-bold text-dark-charcoal mt-1">{{ $approvedCount }}</h3>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-check-circle text-xl"></i>
        </div>
    </div>

    <!-- Pending -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden flex items-center justify-between group">
        <div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Pending Review</p>
            <h3 class="text-3xl font-bold text-dark-charcoal mt-1">{{ $pendingCount }}</h3>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300 animate-pulse">
            <i class="fas fa-clock text-xl"></i>
        </div>
    </div>

    <!-- Rejected -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden flex items-center justify-between group">
        <div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Rejected</p>
            <h3 class="text-3xl font-bold text-dark-charcoal mt-1">{{ $rejectedCount }}</h3>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-times-circle text-xl"></i>
        </div>
    </div>
</div>

<!-- Products Grid -->
@if($products->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $product)
            <div class="glass-card rounded-3xl overflow-hidden group hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full">
                <!-- Image -->
                <div class="relative h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <i class="fas fa-image text-4xl text-gray-300"></i>
                    @endif

                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4">
                        @if($product->status == 'active')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-500/90 text-white backdrop-blur-sm shadow-sm">
                                Approved
                            </span>
                        @elseif($product->status == 'pending')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-500/90 text-white backdrop-blur-sm shadow-sm animate-pulse">
                                Pending
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-500/90 text-white backdrop-blur-sm shadow-sm">
                                Rejected
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Info -->
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="font-bold text-lg text-dark-charcoal mb-1 line-clamp-1 group-hover:text-primary-cyan transition-colors">{{ $product->name }}</h3>
                    
                    <div class="flex items-center gap-2 mb-4 text-sm text-gray-500">
                        <i class="fas fa-store text-xs text-gray-400"></i>
                        <span class="line-clamp-1">{{ $product->seller->shop_name ?? 'Unknown Shop' }}</span>
                    </div>

                    <div class="text-xl font-extrabold text-primary-cyan mb-6">
                        ₹{{ number_format($product->price, 2) }}
                    </div>

                    <!-- Actions -->
                    <div class="mt-auto flex gap-3">
                        @if($product->status == 'pending')
                            <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full py-2.5 rounded-xl bg-green-50 text-green-600 font-medium hover:bg-green-500 hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                                    <i class="fas fa-check"></i>
                                    Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.products.reject', $product) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full py-2.5 rounded-xl bg-red-50 text-red-600 font-medium hover:bg-red-500 hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                                    <i class="fas fa-times"></i>
                                    Reject
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full py-2.5 rounded-xl bg-red-50 text-red-600 font-medium hover:bg-red-500 hover:text-white transition-all duration-300 flex items-center justify-center gap-2" 
                                        onclick="return confirm('Delete this product permanently?')">
                                    <i class="fas fa-trash"></i>
                                    Delete Product
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="glass-card rounded-3xl p-12 text-center">
        <div class="w-20 h-20 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-6 text-gray-300">
            <i class="fas fa-box-open text-4xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-700 mb-2">No Products Found</h3>
        <p class="text-gray-500">Review queue is clear.</p>
    </div>
@endif

@if($products->hasPages())
    <div class="mt-8">
        {{ $products->links() }}
    </div>
@endif

@endsection
