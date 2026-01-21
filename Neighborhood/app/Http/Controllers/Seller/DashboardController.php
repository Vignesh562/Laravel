<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $seller = Auth::guard('seller')->user()->seller;

        $stats = [
            'total_products' => $seller->products()->count(),
            'active_products' => $seller->products()->where('status', 'active')->count(),
            'pending_products' => $seller->products()->where('status', 'pending')->count(),
            'total_orders' => OrderItem::whereIn('product_id', $seller->products->pluck('id'))->count(),
            'total_revenue' => OrderItem::whereIn('product_id', $seller->products->pluck('id'))->sum('subtotal'),
        ];

        // Recent orders for seller's products
        $recent_orders = OrderItem::with(['order.user', 'product'])
            ->whereIn('product_id', $seller->products->pluck('id'))
            ->latest()
            ->take(10)
            ->get();

        // Sales data for chart (last 7 days)
        $sales_data = OrderItem::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(subtotal) as total')
            ->whereIn('product_id', $seller->products->pluck('id'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top selling products
        $top_products = Product::where('seller_id', $seller->id)
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        return view('seller.dashboard', compact('stats', 'recent_orders', 'sales_data', 'top_products'));
    }
}
