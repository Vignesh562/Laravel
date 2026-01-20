<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.admin.login'); // your login blade
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            return redirect()->intended(route('admin.dashboard')); // redirect to admin dashboard
        }

        return back()->with('error', 'Invalid credentials')->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
