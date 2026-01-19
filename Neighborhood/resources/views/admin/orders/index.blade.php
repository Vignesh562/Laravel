@extends('layouts.admin')

@section('page-title', 'Orders')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Pending -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden flex items-center justify-between group">
        <div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Pending</p>
            <h3 class="text-3xl font-bold text-dark-charcoal mt-1">{{ $pendingOrders }}</h3>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300 animate-pulse">
            <i class="fas fa-clock text-xl"></i>
        </div>
    </div>

    <!-- Processing -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden flex items-center justify-between group">
        <div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Processing</p>
            <h3 class="text-3xl font-bold text-dark-charcoal mt-1">{{ $processingOrders }}</h3>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-cog text-xl"></i>
        </div>
    </div>

    <!-- Delivered -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden flex items-center justify-between group">
        <div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Delivered</p>
            <h3 class="text-3xl font-bold text-dark-charcoal mt-1">{{ $deliveredOrders }}</h3>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-check-circle text-xl"></i>
        </div>
    </div>

    <!-- Cancelled -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden flex items-center justify-between group">
        <div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Cancelled</p>
            <h3 class="text-3xl font-bold text-dark-charcoal mt-1">{{ $cancelledOrders }}</h3>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-ban text-xl"></i>
        </div>
    </div>
</div>

<div class="glass-card rounded-3xl overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white/50">
        <h3 class="text-lg font-bold text-dark-charcoal flex items-center gap-2">
            <i class="fas fa-shopping-cart text-primary-cyan"></i>
            All Orders
        </h3>
        <div class="flex gap-2">
            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-bold">
                Total: {{ $orders->total() }}
            </span>
        </div>
    </div>

    @if($orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Order ID</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Total Amount</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Date & Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($orders as $order)
                        <tr class="group hover:bg-white/60 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm font-bold text-primary-cyan">#{{ $order->id }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                                    </div>
                                    <div class="font-medium text-gray-900">{{ $order->user->name ?? 'Guest User' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-dark-charcoal font-extrabold">₹{{ number_format($order->total_amount, 2) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($order->status == 'delivered')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Delivered
                                    </span>
                                @elseif($order->status == 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                        Pending
                                    </span>
                                @elseif($order->status == 'processing')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                        Processing
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-gray-500">
                                {{ $order->created_at->format('M d, Y h:i A') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-white/30">
                {{ $orders->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                <i class="fas fa-shopping-cart text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900">No orders found</h3>
            <p class="text-gray-500">When customers place orders, they will appear here.</p>
        </div>
    @endif
</div>

@endsection
