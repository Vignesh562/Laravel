<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerAuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.seller.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('seller')->attempt($credentials, $request->filled('remember'))) {
            $seller = Auth::guard('seller')->user();

            // Check if seller profile exists
            if (!$seller->seller) {
                Auth::guard('seller')->logout();
                return back()->withErrors([
                    'email' => 'You are not registered as a seller.',
                ]);
            }

            // Check approval status
            if ($seller->seller->status !== 'approved') {
                Auth::guard('seller')->logout();
                return back()->withErrors([
                    'email' => 'Your seller account is pending approval.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended(route('seller.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Show registration form
    public function showRegisterForm()
    {
        return view('auth.seller.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'shop_name' => 'required|string|max:255',
            'shop_address' => 'nullable|string|max:255',
            'shop_description' => 'nullable|string',
        ]);

        try {
            // Create a new user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
            ]);

            // Create the seller profile linked to the user
            Seller::create([
                'user_id' => $user->id, // mandatory to avoid NOT NULL error
                'shop_name' => $validated['shop_name'],
                'shop_address' => $validated['shop_address'] ?? null,
                'shop_description' => $validated['shop_description'] ?? null,
                'status' => 'pending', // admin must approve
            ]);

            return redirect()->route('seller.login')
                ->with('success', 'Registration successful! Please wait for admin approval.');

        } catch (\Exception $e) {
            // If user was created but seller failed, we might want to delete the user to clean up
            // identifying duplicate email errors vs other errors
            if (isset($user) && $user->exists) {
                $user->delete();
            }

            return back()->withInput()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('seller')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('seller.login');
    }
}
