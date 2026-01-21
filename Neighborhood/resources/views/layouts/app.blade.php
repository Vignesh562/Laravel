<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Neighborhood E-Commerce') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Global Styles -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    
    <style>
        /* Header Styles */
        .main-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .main-header.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
            max-width: 1280px;
            margin: 0 auto;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-cyan), var(--primary-turquoise));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
        }

        .logo i {
            font-size: 2rem;
            background: linear-gradient(135deg, var(--primary-cyan), var(--primary-turquoise));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .main-nav {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            color: var(--gray-700);
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, var(--primary-cyan), var(--primary-turquoise));
            transition: width 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary-cyan);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-links a.active {
            color: var(--primary-cyan);
        }

        .nav-links a.active::after {
            width: 100%;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .cart-icon {
            position: relative;
            color: var(--gray-700);
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }

        .cart-icon:hover {
            color: var(--primary-cyan);
            transform: scale(1.1);
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(135deg, var(--coral-red), #dc2626);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }

        .user-menu {
            position: relative;
        }

        .user-menu-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: var(--gray-100);
            border-radius: var(--radius-full);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-menu-toggle:hover {
            background: var(--gray-200);
        }

        .user-menu-toggle i {
            color: var(--primary-cyan);
        }

        .mobile-menu-toggle {
            display: none;
            font-size: 1.5rem;
            color: var(--gray-700);
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Footer Styles */
        .main-footer {
            background: linear-gradient(135deg, var(--dark-charcoal), var(--gray-900));
            color: var(--gray-300);
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 3rem 1.5rem 2rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-column h4 {
            color: var(--white);
            font-size: 1.125rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary-cyan), var(--primary-turquoise));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-column ul li {
            margin-bottom: 0.75rem;
        }

        .footer-column a {
            color: var(--gray-400);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-column a:hover {
            color: var(--primary-cyan);
            transform: translateX(5px);
        }

        .footer-column p {
            color: var(--gray-400);
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: var(--gray-400);
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: linear-gradient(135deg, var(--primary-cyan), var(--primary-turquoise));
            color: var(--white);
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            text-align: center;
            color: var(--gray-500);
        }

        .footer-bottom p {
            margin: 0;
        }

        /* Main Content */
        .main-content {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .nav-links,
            .nav-actions {
                display: none;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .logo {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="main-header" id="mainHeader">
        <div class="header-container">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="logo">
                <i class="fas fa-store"></i>
                <span>NeighborMart</span>
            </a>

            <!-- Navigation -->
            <nav class="main-nav">
                <ul class="nav-links">
                    <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="{{ request()->is('products*') ? 'active' : '' }}">Products</a></li>
                    @auth
                        <li><a href="{{ route('orders.index') }}" class="{{ request()->is('orders*') ? 'active' : '' }}">My Orders</a></li>
                        <li><a href="{{ route('profile.index') }}" class="{{ request()->is('profile*') ? 'active' : '' }}">Profile</a></li>
                    @endauth
                </ul>
            </nav>

            <!-- Actions -->
            <div class="nav-actions">
                @auth
                    <a href="{{ route('cart.index') }}" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="cart-badge">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                    <div class="user-menu">
                        <div class="user-menu-toggle">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                    <form action="{{ route('user.logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('user.login') }}" class="btn btn-outline btn-sm">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </a>
                    <a href="{{ route('user.register') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-user-plus"></i>
                        Sign Up
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success fade-in">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-error fade-in">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-grid">
                <!-- About Column -->
                <div class="footer-column">
                    <h4>About NeighborMart</h4>
                    <p>Your trusted neighborhood marketplace connecting local sellers with customers. Shop local, support your community.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-column">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="{{ route('products.index') }}"><i class="fas fa-chevron-right"></i> Browse Products</a></li>
                        <li><a href="{{ url('/') }}"><i class="fas fa-chevron-right"></i> Categories</a></li>
                        @auth
                            <li><a href="{{ route('orders.index') }}"><i class="fas fa-chevron-right"></i> My Orders</a></li>
                            <li><a href="{{ route('profile.index') }}"><i class="fas fa-chevron-right"></i> My Profile</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Customer Service -->
                <div class="footer-column">
                    <h4>Customer Service</h4>
                    <ul>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> FAQs</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Shipping Info</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Returns Policy</a></li>
                    </ul>
                </div>

                <!-- For Sellers -->
                <div class="footer-column">
                    <h4>For Sellers</h4>
                    <ul>
                        <li><a href="{{ route('seller.register') }}"><i class="fas fa-chevron-right"></i> Become a Seller</a></li>
                        <li><a href="{{ route('seller.login') }}"><i class="fas fa-chevron-right"></i> Seller Login</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Seller Guidelines</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Pricing</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} NeighborMart. All rights reserved. | Built with <i class="fas fa-heart" style="color: var(--coral-red);"></i> for local communities</p>
            </div>
        </div>
    </footer>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('mainHeader');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>
</body>
</html>
