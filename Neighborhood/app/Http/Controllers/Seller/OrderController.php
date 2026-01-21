<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $seller = auth()->guard('seller')->user()->seller;
        
        // Get all order items for this seller's products
        $orderItems = OrderItem::whereHas('product', function($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        })
        ->with(['order.user', 'product'])
        ->latest()
        ->get();
        
        // Group by order
        $orders = $orderItems->groupBy('order_id')->map(function($items) {
            $firstItem = $items->first();
            return (object)[
                'order' => $firstItem->order,
                'items' => $items,
                'total' => $items->sum('subtotal'),
                'item_count' => $items->count(),
            ];
        });
        
        return view('seller.orders.index', compact('orders'));
    }
    
    public function show($orderId)
    {
        $seller = auth()->guard('seller')->user()->seller;
        
        $orderItems = OrderItem::where('order_id', $orderId)
            ->whereHas('product', function($query) use ($seller) {
                $query->where('seller_id', $seller->id);
            })
            ->with(['order.user', 'product'])
            ->get();
            
        if ($orderItems->isEmpty()) {
            abort(404);
        }
        
        $order = $orderItems->first()->order;
        
        return view('seller.orders.show', compact('order', 'orderItems'));
    }
}
