<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')
            ->with(['category', 'seller'])
            ->latest()
            ->paginate(12);
            
        $categories = Category::withCount('products')->get();
        
        return view('products.index', compact('products', 'categories'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $products = Product::where('status', 'active')
            ->where('category_id', $category->id)
            ->with(['category', 'seller'])
            ->latest()
            ->paginate(12);
            
        $categories = Category::withCount('products')->get();
        
        return view('products.index', compact('products', 'categories', 'category'));
    }

    public function show(Product $product)
    {
        if ($product->status !== 'active') {
            abort(404);
        }
        
        $product->load(['category', 'seller']);
        
        // Get related products from same category
        $relatedProducts = Product::where('status', 'active')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
        
        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $products = Product::where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->with(['category', 'seller'])
            ->latest()
            ->paginate(12);
            
        $categories = Category::withCount('products')->get();
        
        return view('products.index', compact('products', 'categories', 'query'));
    }
}
