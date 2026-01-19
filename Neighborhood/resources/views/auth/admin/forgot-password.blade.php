@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#f6f8f8] py-12 px-4 sm:px-6 lg:px-8 animate-fade-in relative overflow-hidden">
    <!-- Background Elements for Admin -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-[#13c8ec]/20 rounded-full blur-3xl opacity-50 animate-pulse"></div>
        <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-[#13ecc8]/20 rounded-full blur-3xl opacity-50 animate-pulse" style="animation-delay: 1.5s;"></div>
    </div>

    <div class="max-w-md w-full space-y-8 glass-card p-10 rounded-3xl shadow-2xl border border-white/20 backdrop-blur-md relative z-10 hover:shadow-3xl transition-shadow duration-500 animate-scale-in">
        
        <!-- Header -->
        <div class="text-center">
            <div class="w-20 h-20 mx-auto bg-gradient-to-tr from-[#13c8ec] to-[#13ecc8] rounded-full flex items-center justify-center shadow-xl transform transition-transform duration-500 hover:scale-110 group">
                <i class="fas fa-user-shield text-white text-3xl group-hover:scale-110 transition-transform duration-300"></i>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-[#2E282A]">Admin Reset</h2>
            <p class="mt-2 text-sm text-[#718991]">
                Securely reset your administrator password.
            </p>
        </div>

        <!-- Status Message -->
        @if (session('status'))
            <div class="bg-[#13ecc8]/10 border border-[#13ecc8]/50 text-[#13c8ec] px-4 py-3 rounded-xl text-center font-medium animate-fade-in flex items-center justify-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm animate-fade-in">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admin.password.update') }}" method="POST" class="mt-8 space-y-6">
            @csrf

            <div class="space-y-5">
                <!-- Email -->
                <div class="relative group">
                    <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        autocomplete="email" 
                        required
                        placeholder="Admin Email Address"
                        value="{{ old('email') }}"
                        class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 bg-white/50 focus:bg-white placeholder-gray-400 text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition-all duration-300 shadow-sm hover:border-[#13c8ec]/50"
                    >
                </div>

                <!-- New Password -->
                <div class="relative group">
                    <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        required
                        placeholder="New Password"
                        class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 bg-white/50 focus:bg-white placeholder-gray-400 text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition-all duration-300 shadow-sm hover:border-[#13c8ec]/50"
                    >
                </div>

                <!-- Confirm Password -->
                <div class="relative group">
                    <i class="fas fa-check-double absolute left-4 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                    <input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        required
                        placeholder="Confirm New Password"
                        class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 bg-white/50 focus:bg-white placeholder-gray-400 text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition-all duration-300 shadow-sm hover:border-[#13c8ec]/50"
                    >
                </div>
            </div>

            <div>
                <button type="submit" class="w-full py-3.5 rounded-xl text-white font-bold tracking-wide bg-gradient-to-r from-[#13c8ec] to-[#13ecc8] hover:from-[#13ecc8] hover:to-[#13c8ec] transition-all duration-300 shadow-lg hover:shadow-[#13c8ec]/40 flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                    <i class="fas fa-save"></i>
                    Reset Password
                </button>
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('admin.login') }}" class="group inline-flex items-center gap-2 text-sm font-medium text-[#718991] hover:text-[#13c8ec] transition-colors duration-300">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-300"></i>
                    Back to Admin Login
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
    .animate-fade-in { animation: fade-in 0.8s ease-out; }

    @keyframes scale-in { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    .animate-scale-in { animation: scale-in 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
</style>
@endsection
