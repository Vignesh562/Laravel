<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserAuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.user.login'); // your login blade
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            return redirect()->intended(route('home')); // redirect to user home
        }

        return back()->with('error', 'Invalid credentials')->withInput();
    }

    // Show registration form
    public function showRegisterForm()
    {
        return view('auth.user.register'); // your register blade
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'phone'                 => 'nullable|string|max:20',
            'address'               => 'nullable|string|max:255',
            'password'              => 'required|string|confirmed|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Account created successfully!');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('user.login');
    }
}
