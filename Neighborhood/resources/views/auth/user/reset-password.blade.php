@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#f6f8f8] py-12 px-4 sm:px-6 lg:px-8 animate-fade-in">
    <div class="max-w-md w-full space-y-8 glass-card p-10 rounded-3xl shadow-2xl border border-white/20 backdrop-blur-md hover:shadow-3xl transition-shadow duration-500 animate-scale-in">

        <!-- Header -->
        <div class="text-center">
            <div class="w-20 h-20 mx-auto bg-gradient-to-tr from-[#13c8ec] to-[#13ecc8] rounded-full flex items-center justify-center shadow-xl transform transition-transform duration-500 hover:scale-110">
                <i class="fas fa-key text-white text-3xl"></i>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-[#2E282A]">Set New Password</h2>
            <p class="mt-2 text-sm text-[#718991]">
                Enter your new password to secure your account.
            </p>
        </div>

        <!-- Form -->
        <form action="{{ route('user.password.update') }}" method="POST" class="mt-8 space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="space-y-4">

                <!-- Email -->
                <div class="relative group">
                    <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        autocomplete="email" 
                        required
                        placeholder="Email Address"
                        value="{{ $email ?? old('email') }}"
                        class="w-full px-12 py-3 rounded-xl border border-[#13c8ec] placeholder-[#718991] text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition duration-300"
                    >
                    @error('email')
                        <p class="text-[#FF6B6B] text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="relative group">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        required
                        placeholder="New Password"
                        class="w-full px-12 py-3 rounded-xl border border-[#13c8ec] placeholder-[#718991] text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition duration-300"
                    >
                    @error('password')
                        <p class="text-[#FF6B6B] text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="relative group">
                    <i class="fas fa-lock-keyhole absolute left-3 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                    <input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        required
                        placeholder="Confirm New Password"
                        class="w-full px-12 py-3 rounded-xl border border-[#13c8ec] placeholder-[#718991] text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition duration-300"
                    >
                </div>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold bg-gradient-to-r from-[#13c8ec] to-[#13ecc8] hover:from-[#13ecc8] hover:to-[#13c8ec] transition-all duration-300 shadow-md flex items-center justify-center gap-2 transform hover:scale-105">
                    <i class="fas fa-sync-alt animate-spin-slow"></i>
                    Reset Password
                </button>
            </div>

            <!-- Back to Login -->
            <div class="text-center mt-4">
                <a href="{{ route('user.login') }}" class="font-medium text-[#13c8ec] hover:text-[#13ecc8] transition-colors duration-300">
                    Back to Login
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
    .animate-fade-in { animation: fade-in 0.8s ease-in-out; }

    @keyframes scale-in { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    .animate-scale-in { animation: scale-in 0.8s ease-in-out; }

    @keyframes spin-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .animate-spin-slow { animation: spin-slow 3s linear infinite; }
</style>
@endsection
