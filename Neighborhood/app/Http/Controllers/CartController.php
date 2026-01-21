<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $product = Product::with('seller')->findOrFail($request->product_id);
        
        if ($product->status !== 'approved') {
            return back()->with('error', 'Product is not available');
        }

        if ($product->stock < ($request->quantity ?? 1)) {
            return back()->with('error', 'Insufficient stock');
        }
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + ($request->quantity ?? 1);
            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Insufficient stock');
            }
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity ?? 1,
                'image' => $product->image,
                'stock' => $product->stock,
                'seller_name' => $product->seller->shop_name,
            ];
        }
        
        session()->put('cart', $cart);
        
        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            if ($request->quantity > $cart[$id]['stock']) {
                return back()->with('error', 'Insufficient stock');
            }
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        
        return back()->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return back()->with('success', 'Item removed from cart!');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared!');
    }
}
