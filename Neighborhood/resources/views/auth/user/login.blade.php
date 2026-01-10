<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - NeighborMart</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
        .animate-fade-in { animation: fade-in 0.8s ease-in-out; }

        @keyframes scale-in { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        .animate-scale-in { animation: scale-in 0.8s ease-in-out; }
    </style>
</head>
<body class="bg-[#f6f8f8]">

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 animate-fade-in">
    <div class="max-w-md w-full space-y-8 glass-card p-10 rounded-3xl shadow-2xl border border-white/20 hover:shadow-3xl transition-shadow duration-500 animate-scale-in">
        
        <!-- Header -->
        <div class="text-center">
            <div class="w-20 h-20 mx-auto bg-gradient-to-tr from-[#13c8ec] to-[#13ecc8] rounded-full flex items-center justify-center shadow-xl transform transition-transform duration-500 hover:scale-110">
                <i class="fas fa-store text-white text-3xl"></i>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-[#2E282A]">Welcome Back!</h2>
            <p class="mt-2 text-sm text-[#718991]">
                Login to continue shopping
            </p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('user.login.submit') }}" method="POST" class="mt-8 space-y-6">
            @csrf

            <div class="space-y-4">
                <!-- Email -->
                <div class="relative group">
                    <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                    <input 
                        type="email" 
                        name="email" 
                        class="w-full px-12 py-3 rounded-xl border border-[#13c8ec] placeholder-[#718991] text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition duration-300"
                        placeholder="Email Address"
                        value="{{ old('email') }}" required autofocus
                    >
                </div>
                @error('email') <p class="text-[#FF6B6B] text-xs mt-1">{{ $message }}</p> @enderror

                <!-- Password -->
                <div class="relative group">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                    <input 
                        type="password" 
                        name="password" 
                        class="w-full px-12 py-3 rounded-xl border border-[#13c8ec] placeholder-[#718991] text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition duration-300"
                        placeholder="Password" required
                    >
                </div>
                @error('password') <p class="text-[#FF6B6B] text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-[#13c8ec] focus:ring-[#13c8ec] border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-[#2E282A]">
                        Remember me
                    </label>
                </div>

                <div class="text-sm">
                    <a href="{{ route('user.password.request') }}" class="font-medium text-[#13c8ec] hover:text-[#13ecc8] transition-colors duration-300">
                        Forgot Password?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold bg-gradient-to-r from-[#13c8ec] to-[#13ecc8] hover:from-[#13ecc8] hover:to-[#13c8ec] transition-all duration-300 shadow-md flex items-center justify-center gap-2 transform hover:scale-105">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </button>
            </div>

            <div class="relative mt-4">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">
                        Or
                    </span>
                </div>
            </div>

            <div class="text-center mt-2">
                <p class="text-sm text-[#718991]">
                    Don't have an account? 
                    <a href="{{ route('user.register') }}" class="font-medium text-[#13c8ec] hover:text-[#13ecc8] transition-colors duration-300">
                        Sign Up
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

<div class="text-center pb-8">
    <a href="{{ url('/') }}" class="font-medium text-[#718991] hover:text-[#13c8ec] transition-colors duration-300 flex items-center justify-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>
</div>

</body>
</html>
