@extends('layouts.user')

@section('page-title', 'My Orders')

@section('content')

@if($orders->count() > 0)
    <div class="space-y-6">
        @foreach($orders as $index => $order)
            <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border border-white/60 overflow-hidden">
                <!-- Order Header -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 p-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
                    <div>
                        <div class="flex items-center gap-2 text-xl font-bold text-gray-800 mb-2">
                            <span class="text-primary-cyan">#{{ $order->id }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-calendar"></i>
                            <span>{{ $order->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>
                    <div>
                        @if($order->status == 'delivered')
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                Delivered
                            </span>
                        @elseif($order->status == 'pending')
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold bg-orange-100 text-orange-800">
                                <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                                Pending
                            </span>
                        @elseif($order->status == 'processing')
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                Processing
                            </span>
                        @elseif($order->status == 'shipped')
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                                Shipped
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                {{ ucfirst($order->status) }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="p-6 space-y-4">
                    @foreach($order->orderItems->take(3) as $item)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-colors">
                            <div class="w-20 h-20 bg-white rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-image text-3xl text-gray-300"></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-gray-800 truncate">{{ $item->product_name }}</h4>
                                <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-xl font-bold text-primary-cyan">₹{{ number_format($item->price * $item->quantity, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                    
                    @if($order->orderItems->count() > 3)
                        <div class="text-center text-sm text-gray-500 py-2">
                            +{{ $order->orderItems->count() - 3 }} more items
                        </div>
                    @endif
                </div>

                <!-- Order Footer -->
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 p-6 bg-gray-50 border-t border-gray-200">
                    <div class="text-2xl font-black text-gray-800">
                        Total: <span class="text-primary-cyan">₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-cyan to-primary-turquoise text-white font-bold rounded-xl hover:scale-105 transition-transform duration-300 shadow-lg shadow-primary-cyan/30">
                        <i class="fas fa-eye"></i>
                        <span>View Details</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
@else
    <!-- Empty State -->
    <div class="text-center py-16 bg-white/90 backdrop-blur-sm rounded-3xl shadow-lg border border-white/60">
        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
            <i class="fas fa-clipboard-list text-6xl text-gray-300"></i>
        </div>
        <h3 class="text-3xl font-bold text-gray-800 mb-3">No Orders Yet</h3>
        <p class="text-gray-500 mb-8 text-lg">You haven't placed any orders yet. Start shopping to see your orders here!</p>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-primary-cyan to-primary-turquoise text-white font-bold rounded-2xl hover:scale-105 transition-transform duration-300 shadow-lg shadow-primary-cyan/30">
            <i class="fas fa-shopping-bag"></i>
            <span>Start Shopping</span>
        </a>
    </div>
@endif

<!-- Tailwind Config -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: {
                        cyan: '#13c8ec',
                        turquoise: '#13ecc8',
                    }
                }
            }
        }
    }
</script>

@endsection
