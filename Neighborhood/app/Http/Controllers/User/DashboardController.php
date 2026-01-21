<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get user stats
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)->where('status', 'pending')->count();
        $processingOrders = Order::where('user_id', $user->id)->where('status', 'processing')->count();
        $deliveredOrders = Order::where('user_id', $user->id)->where('status', 'delivered')->count();
        
        // Get recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->with(['orderItems.product'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('user.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'deliveredOrders',
            'recentOrders'
        ));
    }
}
