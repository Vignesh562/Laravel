<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        return view('seller.settings');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_description' => 'nullable|string',
        ]);

        auth()->guard('seller')->user()->seller->update($validated);

        return redirect()->route('seller.settings.index')
            ->with('success', 'Shop information updated successfully!');
    }

    public function updateAccount(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->guard('seller')->id(),
            'phone' => 'nullable|string|max:20',
        ]);

        auth()->guard('seller')->user()->update($validated);

        return redirect()->route('seller.settings.index')
            ->with('success', 'Account information updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->guard('seller')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('seller.settings.index')
            ->with('success', 'Password changed successfully!');
    }
}
