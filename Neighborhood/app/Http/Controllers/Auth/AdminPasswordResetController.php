<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminPasswordResetController extends Controller
{
    /**
     * Display the form to request a password reset (now direct reset).
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Reset the admin's password directly.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $admin = \App\Models\Admin::where('email', $request->email)->first();

        if ($admin) {
            $admin->forceFill([
                'password' => Hash::make($request->password)
            ])->setRememberToken(Str::random(60));

            $admin->save();

            return redirect()->route('admin.login')->with('success', 'Password has been reset successfully.');
        }

        return back()->withErrors(['email' => 'We can\'t find an admin with that email address.']);
    }
}
