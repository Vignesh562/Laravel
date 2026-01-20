<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Calculate counts directly from database for accuracy
        $approvedCount = Product::where('status', 'active')->count();
        $pendingCount = Product::where('status', 'pending')->count();
        $rejectedCount = Product::where('status', 'inactive')->count();

        $products = Product::with(['seller.user', 'category'])->latest()->paginate(12);
        
        return view('admin.products.index', compact('products', 'approvedCount', 'pendingCount', 'rejectedCount'));
    }

    public function show(Product $product)
    {
        $product->load('seller.user', 'category', 'reviews');
        return view('admin.products.show', compact('product'));
    }

    public function approve(Product $product)
    {
        $product->update(['status' => 'active']);
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product approved and is now active!');
    }

    public function reject(Product $product)
    {
        $product->update(['status' => 'inactive']);
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product rejected and set to inactive.');
    }

    public function destroy(Product $product)
    {
        // Delete product image if exists
        if ($product->main_image && \Storage::disk('public')->exists($product->main_image)) {
            \Storage::disk('public')->delete($product->main_image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
