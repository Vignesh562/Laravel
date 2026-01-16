@extends('layouts.admin')

@section('page-title', 'Sellers')

@section('content')

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <!-- Approved -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden flex items-center justify-between group">
        <div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Approved</p>
            <h3 class="text-3xl font-bold text-dark-charcoal mt-1">{{ $sellers->where('status', 'approved')->count() }}</h3>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-check-circle text-xl"></i>
        </div>
    </div>

    <!-- Pending -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden flex items-center justify-between group">
        <div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Pending</p>
            <h3 class="text-3xl font-bold text-dark-charcoal mt-1">{{ $sellers->where('status', 'pending')->count() }}</h3>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-clock text-xl"></i>
        </div>
    </div>

    <!-- Rejected -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden flex items-center justify-between group">
        <div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Rejected</p>
            <h3 class="text-3xl font-bold text-dark-charcoal mt-1">{{ $sellers->where('status', 'rejected')->count() }}</h3>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-times-circle text-xl"></i>
        </div>
    </div>
</div>

<!-- Sellers Table -->
<div class="glass-card rounded-3xl overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white/50">
        <h3 class="text-lg font-bold text-dark-charcoal flex items-center gap-2">
            <i class="fas fa-store text-primary-cyan"></i>
            All Sellers
        </h3>
        <div class="text-sm text-gray-500">
            Total: <strong>{{ $sellers->count() }}</strong>
        </div>
    </div>

    @if($sellers->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Seller</th>
                        <th class="px-6 py-4">Shop Details</th>
                        <th class="px-6 py-4">Contact</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Joined</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($sellers as $seller)
                        <tr class="group hover:bg-white/60 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-cyan to-primary-turquoise p-[2px] flex-shrink-0">
                                        <div class="w-full h-full rounded-full bg-white flex items-center justify-center text-primary-cyan font-bold text-sm">
                                            {{ strtoupper(substr($seller->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $seller->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $seller->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $seller->shop_name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $seller->phone ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($seller->status == 'approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Approved
                                    </span>
                                @elseif($seller->status == 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 animate-pulse">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $seller->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($seller->status == 'pending')
                                        <form action="{{ route('admin.sellers.approve', $seller) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-full bg-green-50 text-green-600 hover:bg-green-500 hover:text-white transition-all duration-200 flex items-center justify-center" title="Approve">
                                                <i class="fas fa-check text-xs"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.sellers.reject', $seller) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-full bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-all duration-200 flex items-center justify-center" title="Reject">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400 italic">No actions</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                <i class="fas fa-store text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900">No sellers found</h3>
            <p class="text-gray-500">New seller registrations will appear here.</p>
        </div>
    @endif
</div>

@endsection
