<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats for Dashboard
        $totalUsers = User::count();
        $totalSellers = Seller::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        
        // Stats for view (not used directly but kept for potential future use if view updates)
        $stats = [
            'total_users' => $totalUsers,
            'total_sellers' => $totalSellers,
            'total_products' => $totalProducts,
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'pending_sellers' => Seller::where('status', 'pending')->count(),
            'pending_products' => Product::where('status', 'pending')->count(),
        ];

        // Recent orders
        $recent_orders = Order::with('user')->latest()->take(10)->get();

        // Pending seller approvals
        $pending_sellers = Seller::with('user')->where('status', 'pending')->latest()->take(5)->get();

        // Sales data for chart (last 7 days)
        $sales_data = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(total_amount) as total')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Category distribution
        $category_stats = Category::withCount('products')->get();

        return view('admin.dashboard', compact(
            'stats', 
            'totalUsers', 'totalSellers', 'totalProducts', 'totalOrders', 'totalRevenue',
            'recent_orders', 'pending_sellers', 'sales_data', 'category_stats'
        ));
    }
}
