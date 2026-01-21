<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Account - {{ config('app.name', 'NeighborMart') }}</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            cyan: '#13c8ec',
                            turquoise: '#13ecc8',
                        },
                        dark: {
                            charcoal: '#2E282A',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #f6f8f8;
            font-family: 'Inter', sans-serif;
        }

        .glass-sidebar {
            background: linear-gradient(180deg, #2E282A 0%, #1a1617 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .nav-link.active {
            background: rgba(19, 200, 236, 0.1);
            color: #13c8ec;
            border-right: 3px solid #13c8ec;
        }

        .nav-link:hover:not(.active) {
            background: rgba(255, 255, 255, 0.05);
            color: #13ecc8;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
        .animate-fade-in { animation: fade-in 0.5s ease-out; }
    </style>
</head>
<body class="antialiased text-gray-800">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-72 glass-sidebar flex flex-col fixed inset-y-0 left-0 z-50 transition-transform duration-300 transform md:relative md:translate-x-0">
            
            <!-- Logo -->
            <div class="h-20 flex items-center px-8 border-b border-white/5">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group-hover:scale-105 transition-transform duration-300">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-cyan to-primary-turquoise flex items-center justify-center shadow-lg shadow-primary-cyan/20">
                        <i class="fas fa-store text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg tracking-tight">Neighborhood</h1>
                        <p class="text-xs text-gray-400 font-medium tracking-wide">MY ACCOUNT</p>
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-8">
                
                <!-- Main Section -->
                <div>
                    <h3 class="px-4 text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Overview</h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('user.dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 transition-all duration-300 {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-th-large w-5 text-center"></i>
                                <span class="font-medium text-sm">Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Shopping Section -->
                <div>
                    <h3 class="px-4 text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Shopping</h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('orders.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 transition-all duration-300 {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                                <i class="fas fa-shopping-bag w-5 text-center"></i>
                                <span class="font-medium text-sm">My Orders</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cart.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 transition-all duration-300 {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                                <i class="fas fa-shopping-cart w-5 text-center"></i>
                                <span class="font-medium text-sm">Shopping Cart</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('products.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 transition-all duration-300">
                                <i class="fas fa-store w-5 text-center"></i>
                                <span class="font-medium text-sm">Browse Products</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Account Section -->
                <div>
                    <h3 class="px-4 text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Account</h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('profile.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 transition-all duration-300 {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                <i class="fas fa-user w-5 text-center"></i>
                                <span class="font-medium text-sm">My Profile</span>
                            </a>
                        </li>
                    </ul>
                </div>

            </nav>

            <!-- User Info (Bottom) -->
            <div class="p-4 border-t border-white/5 bg-black/20">
                <div class="flex items-center gap-3 px-2">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-cyan to-primary-turquoise p-[2px]">
                        <div class="w-full h-full rounded-full bg-gray-900 flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email ?? 'user@example.com' }}</p>
                    </div>
                    <form action="{{ route('user.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white transition-colors" title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-[#f6f8f8] relative">
            
            <!-- Header -->
            <header class="h-20 glass-header flex items-center justify-between px-8 z-40">
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-gray-500 hover:text-primary-cyan transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-2xl font-bold text-dark-charcoal tracking-tight">
                        @yield('page-title', 'Dashboard')
                    </h2>
                </div>

                <!-- Header Actions -->
                <div class="flex items-center gap-6">
                    <a href="{{ route('products.index') }}" class="hidden md:flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-primary-cyan to-primary-turquoise text-white font-semibold text-sm shadow-lg shadow-primary-cyan/30 hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-store"></i>
                        <span>Shop Now</span>
                    </a>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-cyan to-primary-turquoise flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="hidden md:block">
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Customer</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-8 relative scroll-smooth">
                <!-- Background Orbs -->
                <div class="fixed top-20 right-0 w-[500px] h-[500px] bg-primary-cyan/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
                <div class="fixed bottom-0 left-64 w-[500px] h-[500px] bg-primary-turquoise/5 rounded-full blur-3xl pointer-events-none -z-10"></div>

                <div class="max-w-7xl mx-auto space-y-6">
                    
                    <!-- Alerts -->
                    @if(session('success'))
                        <div class="animate-fade-in bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                            <button onclick="this.parentElement.remove()" class="ml-auto text-green-500 hover:text-green-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="animate-fade-in bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                            <span class="font-medium">{{ session('error') }}</span>
                            <button onclick="this.parentElement.remove()" class="ml-auto text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="animate-fade-in">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Auto-hide alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('.animate-fade-in');
            alerts.forEach(alert => {
                if(alert.classList.contains('bg-green-50') || alert.classList.contains('bg-red-50')) {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            });
        }, 5000);
    </script>
    @stack('scripts')
</body>
</html>
