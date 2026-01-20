<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserPasswordResetController extends Controller
{
    /**
     * Display the form to request a password reset (now direct reset).
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Reset the user's password directly.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user) {
            $user->forceFill([
                'password' => Hash::make($request->password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            return redirect()->route('user.login')->with('success', 'Password has been reset successfully. Please login with your new password.');
        }

        return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
    }
}
