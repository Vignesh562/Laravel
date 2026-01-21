<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'phone' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'total_amount' => $total,
            'shipping_address' => $validated['shipping_address'],
            'city' => $validated['city'],
            'postal_code' => $validated['postal_code'],
            'phone' => $validated['phone'],
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
            
            // Update product stock
            $product = Product::find($productId);
            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
    }
}
