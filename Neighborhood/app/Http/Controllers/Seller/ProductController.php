<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = auth()->guard('seller')->user()->seller->products()->with('category')->latest()->paginate(12);
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Upload main image
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('products', 'public');
            $validated['main_image'] = $path;
        }

        $validated['seller_id'] = auth()->guard('seller')->user()->seller->id;
        $validated['status'] = 'pending'; // Admin approval required

        Product::create($validated);

        return redirect()->route('seller.products.index')
            ->with('success', 'Product created successfully! Waiting for admin approval.');
    }

    public function edit(Product $product)
    {
        // Ensure seller owns this product
        if ($product->seller_id !== auth()->guard('seller')->user()->seller->id) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // Ensure seller owns this product
        if ($product->seller_id !== auth()->guard('seller')->user()->seller->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Upload new image if provided
        if ($request->hasFile('main_image')) {
            // Delete old image
            if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
                Storage::disk('public')->delete($product->main_image);
            }
            $path = $request->file('main_image')->store('products', 'public');
            $validated['main_image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('seller.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Ensure seller owns this product
        if ($product->seller_id !== auth()->guard('seller')->user()->seller->id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete image
        if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
            Storage::disk('public')->delete($product->main_image);
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
