<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::with('user')->latest()->get();
        return view('admin.sellers.index', compact('sellers'));
    }

    public function show(Seller $seller)
    {
        $seller->load('user', 'products');
        return view('admin.sellers.show', compact('seller'));
    }

    public function approve(Seller $seller)
    {
        $seller->update(['status' => 'approved']);
        
        return redirect()->route('admin.sellers.index')
            ->with('success', 'Seller approved successfully! They can now start selling.');
    }

    public function reject(Seller $seller)
    {
        $seller->update(['status' => 'rejected']);
        
        return redirect()->route('admin.sellers.index')
            ->with('success', 'Seller application rejected.');
    }
}
