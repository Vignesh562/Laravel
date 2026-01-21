<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        
        $featuredProducts = Product::where('status', 'approved')
            ->with(['seller', 'category'])
            ->latest()
            ->take(8)
            ->get();

        $totalProducts = Product::where('status', 'approved')->count();
        $totalSellers = Seller::where('status', 'approved')->count();
        $totalCustomers = User::count();
        $totalCategories = Category::count();

        return view('home', compact(
            'categories',
            'featuredProducts',
            'totalProducts',
            'totalSellers',
            'totalCustomers',
            'totalCategories'
        ));
    }
}
