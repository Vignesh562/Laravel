<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if(request()->is('admin*'))
            Admin Reset - NeighborMart
        @else
            Reset Password - NeighborMart
        @endif
    </title>

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

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 animate-fade-in relative overflow-hidden">
    <!-- Dynamic Background Elements -->
    <div class="absolute inset-0 z-0 pointer-events-none">
        @if(request()->is('admin*'))
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-[#13c8ec]/20 rounded-full blur-3xl opacity-50 animate-pulse"></div>
            <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-[#13ecc8]/20 rounded-full blur-3xl opacity-50 animate-pulse" style="animation-delay: 1.5s;"></div>
        @else
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-[#13c8ec]/20 rounded-full blur-3xl opacity-50 animate-pulse"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-[#13ecc8]/20 rounded-full blur-3xl opacity-50 animate-pulse" style="animation-delay: 1s;"></div>
        @endif
    </div>

    <div class="max-w-md w-full space-y-8 glass-card p-10 rounded-3xl shadow-2xl border border-white/20 hover:shadow-3xl transition-shadow duration-500 animate-scale-in relative z-10">
        
        <!-- Header -->
        <div class="text-center">
            <div class="w-20 h-20 mx-auto bg-gradient-to-tr from-[#13c8ec] to-[#13ecc8] rounded-full flex items-center justify-center shadow-xl transform transition-transform duration-500 hover:scale-110 group">
                @if(request()->is('admin*'))
                    <i class="fas fa-user-shield text-white text-3xl group-hover:scale-110 transition-transform duration-300"></i>
                @else
                    <i class="fas fa-key text-white text-3xl group-hover:rotate-12 transition-transform duration-300"></i>
                @endif
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-[#2E282A]">
                @if(request()->is('admin*'))
                    Admin Reset
                @else
                    Reset Password
                @endif
            </h2>
            <p class="mt-2 text-sm text-[#718991]">
                @if(request()->is('admin*'))
                    Securely reset your administrator password.
                @else
                    Enter your details to set a new password.
                @endif
            </p>
        </div>

        @if(session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ request()->is('admin*') ? route('admin.password.update') : route('user.password.update') }}" method="POST" class="mt-8 space-y-6">
            @csrf

            <div class="space-y-4">
                <!-- Email -->
                <div class="relative group">
                    <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                    <input 
                        type="email" 
                        name="email" 
                        class="w-full px-12 py-3 rounded-xl border border-[#13c8ec] placeholder-[#718991] text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition duration-300"
                        placeholder="{{ request()->is('admin*') ? 'Admin Email Address' : 'Email Address' }}"
                        value="{{ old('email') }}" required autofocus
                    >
                </div>

                <!-- Password -->
                <div class="relative group">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                    <input 
                        type="password" 
                        name="password" 
                        class="w-full px-12 py-3 rounded-xl border border-[#13c8ec] placeholder-[#718991] text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition duration-300"
                        placeholder="New Password" required
                    >
                </div>

                <!-- Confirm Password -->
                <div class="relative group">
                    <i class="fas fa-check-double absolute left-3 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        class="w-full px-12 py-3 rounded-xl border border-[#13c8ec] placeholder-[#718991] text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition duration-300"
                        placeholder="Confirm New Password" required
                    >
                </div>
            </div>

            <div>
                <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold bg-gradient-to-r from-[#13c8ec] to-[#13ecc8] hover:from-[#13ecc8] hover:to-[#13c8ec] transition-all duration-300 shadow-md flex items-center justify-center gap-2 transform hover:scale-105">
                    <i class="fas fa-save"></i>
                    Reset Password
                </button>
            </div>

            <div class="text-center mt-2">
                @if(request()->is('seller*'))
                    <a href="{{ route('seller.login') }}" class="font-medium text-[#718991] hover:text-[#13c8ec] transition-colors duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i> Back to Seller Login
                    </a>
                @elseif(request()->is('admin*'))
                     <a href="{{ route('admin.login') }}" class="font-medium text-[#718991] hover:text-[#13c8ec] transition-colors duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i> Back to Admin Login
                    </a>
                @else
                    <a href="{{ route('user.login') }}" class="font-medium text-[#718991] hover:text-[#13c8ec] transition-colors duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i> Back to Login
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

</body>
</html>
