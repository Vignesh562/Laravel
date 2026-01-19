@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Total Products -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
        <div class="flex justify-between items-start z-10 relative">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Products</p>
                <h3 class="text-3xl font-bold text-dark-charcoal mt-2">{{ $totalProducts ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-cyan to-primary-turquoise flex items-center justify-center text-white shadow-lg shadow-primary-cyan/30 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-box text-xl"></i>
            </div>
        </div>
        <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-primary-cyan/10 rounded-full blur-2xl group-hover:bg-primary-cyan/20 transition-colors duration-300"></div>
    </div>

    <!-- Active Sellers -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
        <div class="flex justify-between items-start z-10 relative">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Active Sellers</p>
                <h3 class="text-3xl font-bold text-dark-charcoal mt-2">{{ $totalSellers ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-store text-xl"></i>
            </div>
        </div>
        <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl group-hover:bg-purple-500/20 transition-colors duration-300"></div>
    </div>

    <!-- Customers -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
        <div class="flex justify-between items-start z-10 relative">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Customers</p>
                <h3 class="text-3xl font-bold text-dark-charcoal mt-2">{{ $totalUsers ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>
        <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-colors duration-300"></div>
    </div>

    <!-- Total Orders -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
        <div class="flex justify-between items-start z-10 relative">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Orders</p>
                <h3 class="text-3xl font-bold text-dark-charcoal mt-2">{{ $totalOrders ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/30 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-shopping-cart text-xl"></i>
            </div>
        </div>
        <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-orange-500/10 rounded-full blur-2xl group-hover:bg-orange-500/20 transition-colors duration-300"></div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Recent Orders (Spans 2 columns) -->
    <div class="lg:col-span-2 glass-card rounded-3xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-dark-charcoal flex items-center gap-2">
                <i class="fas fa-clipboard-list text-primary-cyan"></i>
                Recent Orders
            </h3>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-primary-cyan hover:text-primary-turquoise transition-colors">View All</a>
        </div>

        @if(isset($recentOrders) && $recentOrders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                            <th class="pb-3 pl-2">Order ID</th>
                            <th class="pb-3">Customer</th>
                            <th class="pb-3">Amount</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 pr-2 text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentOrders as $order)
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 pl-2 font-medium text-dark-charcoal group-hover:text-primary-cyan transition-colors">#{{ $order->id }}</td>
                                <td class="py-4 text-gray-600">{{ $order->user->name ?? 'N/A' }}</td>
                                <td class="py-4 font-bold text-dark-charcoal">₹{{ number_format($order->total_amount, 2) }}</td>
                                <td class="py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-4 pr-2 text-right text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                <i class="fas fa-inbox text-4xl mb-3 opacity-50"></i>
                <p>No orders yet</p>
            </div>
        @endif
    </div>

    <!-- Recent Activity / Quick Stats -->
    <div class="space-y-8">
        <!-- Sales Chart -->
        <div class="glass-card rounded-3xl p-6">
            <h3 class="text-lg font-bold text-dark-charcoal mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line text-purple-500"></i>
                Sales Overview
            </h3>
            <div id="salesChart" class="w-full" style="min-height: 250px;"></div>
        </div>

        <!-- Recent Activity (Simplified) -->
        <div class="glass-card rounded-3xl p-6">
            <h3 class="text-lg font-bold text-dark-charcoal mb-4 flex items-center gap-2">
                <i class="fas fa-bell text-orange-500"></i>
                Recent Activity
            </h3>
            <div class="space-y-4">
                <!-- Static placeholders for now, could be dynamic -->
                <div class="flex gap-4 items-start">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 flex-shrink-0 mt-1">
                        <i class="fas fa-user-plus text-xs"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">New customer registered</p>
                        <p class="text-xs text-gray-500">2 hours ago</p>
                    </div>
                </div>
                <div class="flex gap-4 items-start">
                    <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-500 flex-shrink-0 mt-1">
                        <i class="fas fa-box text-xs"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">New product submitted</p>
                        <p class="text-xs text-gray-500">5 hours ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    var options = {
        series: [{
            name: 'Sales',
            data: [30, 40, 35, 50, 49, 60, 70, 91, 125, 100, 110, 95]
        }],
        chart: {
            height: 280,
            type: 'area',
            fontFamily: 'Inter, sans-serif',
            toolbar: { show: false },
            background: 'transparent'
        },
        colors: ['#13c8ec'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.6,
                opacityTo: 0.1,
                stops: [0, 90, 100]
            }
        },
        dataLabels: { enabled: false },
        stroke: {
            curve: 'smooth',
            width: 3,
            colors: ['#13c8ec']
        },
        grid: {
            borderColor: 'rgba(0,0,0,0.05)',
            strokeDashArray: 4,
            yaxis: { lines: { show: true } }
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: { style: { colors: '#9ca3af' } }
        },
        yaxis: {
            labels: { style: { colors: '#9ca3af' } }
        },
        tooltip: {
            theme: 'light',
            y: { formatter: function (val) { return "₹" + val + "k" } }
        }
    };

    var chart = new ApexCharts(document.querySelector("#salesChart"), options);
    chart.render();
</script>
@endpush
@endsection
