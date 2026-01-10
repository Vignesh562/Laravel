<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - NeighborMart</title>

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
    <div class="max-w-2xl w-full space-y-8 glass-card p-10 rounded-3xl shadow-2xl border border-white/20 hover:shadow-3xl transition-shadow duration-500 animate-scale-in">
        
        <!-- Header -->
        <div class="text-center">
            <div class="w-20 h-20 mx-auto bg-gradient-to-tr from-[#13c8ec] to-[#13ecc8] rounded-full flex items-center justify-center shadow-xl transform transition-transform duration-500 hover:scale-110">
                <i class="fas fa-user-plus text-white text-3xl"></i>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-[#2E282A]">Create Account</h2>
            <p class="mt-2 text-sm text-[#718991]">
                Join NeighborMart today
            </p>
        </div>

        <form action="{{ route('user.register.submit') }}" method="POST" class="mt-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="relative group">
                    <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                    <input type="text" name="name" class="w-full px-12 py-3 rounded-xl border border-[#13c8ec] placeholder-[#718991] text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition duration-300" placeholder="Full Name" required>
                </div>

                <!-- Phone -->
                <div class="relative group">
                    <i class="fas fa-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                    <input type="tel" name="phone" class="w-full px-12 py-3 rounded-xl border border-[#13c8ec] placeholder-[#718991] text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition duration-300" placeholder="Phone Number">
                </div>
            </div>

            <!-- Email (Full Width) -->
            <div class="relative group">
                <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                <input type="email" name="email" class="w-full px-12 py-3 rounded-xl border border-[#13c8ec] placeholder-[#718991] text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition duration-300" placeholder="Email Address" required>
            </div>

            <!-- Address (Full Width) -->
            <div class="relative group">
                <i class="fas fa-map-marker-alt absolute left-3 top-4 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                <textarea name="address" rows="2" class="w-full px-12 py-3 rounded-xl border border-[#13c8ec] placeholder-[#718991] text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition duration-300" placeholder="Complete Address"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Password -->
                <div class="relative group">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                    <input type="password" name="password" class="w-full px-12 py-3 rounded-xl border border-[#13c8ec] placeholder-[#718991] text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition duration-300" placeholder="Password" required>
                </div>

                <!-- Confirm Password -->
                <div class="relative group">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-[#718991] group-focus-within:text-[#13c8ec] transition-colors duration-300"></i>
                    <input type="password" name="password_confirmation" class="w-full px-12 py-3 rounded-xl border border-[#13c8ec] placeholder-[#718991] text-[#2E282A] focus:outline-none focus:ring-2 focus:ring-[#13c8ec] focus:border-transparent transition duration-300" placeholder="Confirm Password" required>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold bg-gradient-to-r from-[#13c8ec] to-[#13ecc8] hover:from-[#13ecc8] hover:to-[#13c8ec] transition-all duration-300 shadow-md flex items-center justify-center gap-2 transform hover:scale-105">
                    <i class="fas fa-user-plus"></i>
                    Create Account
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
                    Already have an account? 
                    <a href="{{ route('user.login') }}" class="font-medium text-[#13c8ec] hover:text-[#13ecc8] transition-colors duration-300">
                        Login
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
