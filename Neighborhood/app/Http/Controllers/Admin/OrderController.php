<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        $orders = Order::with(['user', 'orderItems.product'])->latest()->paginate(10);
        
        return view('admin.orders.index', compact('orders', 'totalOrders', 'pendingOrders', 'processingOrders', 'deliveredOrders', 'cancelledOrders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product.seller']);
        return view('admin.orders.show', compact('order'));
    }
}
