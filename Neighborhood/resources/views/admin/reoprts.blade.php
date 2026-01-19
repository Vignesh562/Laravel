@extends('layouts.admin')

@section('page-title', 'Reports')

@section('content')
<style>
    .reports-grid {
        display: grid;
        gap: 2rem;
    }

    .chart-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 2rem;
        box-shadow: var(--shadow-md);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--dark-charcoal);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-title i {
        color: var(--primary-cyan);
    }

    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .metric-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        text-align: center;
    }

    .metric-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary-cyan);
        margin-bottom: 0.5rem;
    }

    .metric-label {
        color: var(--gray-600);
        font-weight: 600;
    }

    @media (max-width: 1024px) {
        .metrics-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .metrics-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="reports-grid fade-in">
    <!-- Platform Metrics -->
    <div class="metrics-grid">
        <div class="metric-card scale-in delay-100">
            <div class="metric-value">₹{{ number_format($totalRevenue ?? 0, 0) }}</div>
            <div class="metric-label">Total Revenue</div>
        </div>
        <div class="metric-card scale-in delay-200">
            <div class="metric-value">{{ $totalOrders ?? 0 }}</div>
            <div class="metric-label">Total Orders</div>
        </div>
        <div class="metric-card scale-in delay-300">
            <div class="metric-value">{{ $totalCustomers ?? 0 }}</div>
            <div class="metric-label">Total Customers</div>
        </div>
        <div class="metric-card scale-in delay-400">
            <div class="metric-value">{{ $activeSellers ?? 0 }}</div>
            <div class="metric-label">Active Sellers</div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="chart-card slide-up">
        <div class="card-title">
            <i class="fas fa-dollar-sign"></i>
            Revenue Overview
        </div>
        <div id="revenueChart" style="min-height: 350px;"></div>
    </div>

    <!-- Category Distribution -->
    <div class="chart-card slide-up delay-100">
        <div class="card-title">
            <i class="fas fa-chart-pie"></i>
            Sales by Category
        </div>
        <div id="categoryChart" style="min-height: 350px;"></div>
    </div>
</div>

@push('scripts')
<script>
    // Revenue Chart
    var revenueOptions = {
        series: [{
            name: 'Revenue',
            data: [31, 40, 28, 51, 42, 109, 100, 120, 95, 110, 130, 145]
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: { show: false }
        },
        colors: ['#13c8ec'],
        dataLabels: { enabled: false },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.2
            }
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "₹" + val + "k"
                }
            }
        }
    };
    new ApexCharts(document.querySelector("#revenueChart"), revenueOptions).render();

    // Category Chart
    var categoryOptions = {
        series: [44, 55, 13, 43, 22],
        chart: {
            height: 350,
            type: 'donut'
        },
        labels: ['Electronics', 'Groceries', 'Clothing', 'Home & Garden', 'Books'],
        colors: ['#13c8ec', '#13ecc8', '#8B8268', '#A87A5B', '#D4AF37'],
        legend: {
            position: 'bottom'
        }
    };
    new ApexCharts(document.querySelector("#categoryChart"), categoryOptions).render();
</script>
@endpush
@endsection
