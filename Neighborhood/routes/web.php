<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\SellerAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\UserPasswordResetController;
use App\Http\Controllers\Auth\AdminPasswordResetController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Product Browsing (Public)
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{slug}', [App\Http\Controllers\ProductController::class, 'category'])->name('products.category');
Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');

// User Shopping (Protected)
Route::middleware(['auth'])->group(function () {
    // Cart
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    
    // Checkout
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    
    // Orders
    Route::get('/my-orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    
    // Profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // User Dashboard
    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');
});

// User Authentication Routes
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UserAuthController::class, 'register'])->name('register.submit');
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

    // Password Reset
    // Password Reset (Direct)
    Route::get('/forgot-password', [UserPasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [UserPasswordResetController::class, 'reset'])->name('password.update');
});

// Seller Authentication Routes
Route::prefix('seller')->name('seller.')->group(function () {
    Route::get('/login', [SellerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [SellerAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [SellerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [SellerAuthController::class, 'register'])->name('register.submit');
    Route::post('/logout', [SellerAuthController::class, 'logout'])->name('logout');

    // Password Reset (Reusing User Controller or we could duplicate if needed, but logic is same for User model)
    // Actually, Seller IS a User, so we can use the same UserPasswordResetController but we might want different view routes if we want to keep 'seller' prefix in URL.
    // For simplicity and reusing the same 'users' broker, we can point to the same controller methods.
    // The controller methods return views like 'auth.user.forgot-password'. We might need to handle this dynamic view rendering if we want 'seller' branding.
    // For now, let's point to the User routes or same controller.
    
    Route::get('/forgot-password', [UserPasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [UserPasswordResetController::class, 'reset'])->name('password.update');
    
    // Seller Panel Routes (Protected)
    Route::middleware(['auth:seller'])->group(function () {
        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', ProductController::class);
        
        // Orders
        Route::get('/orders', [App\Http\Controllers\Seller\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [App\Http\Controllers\Seller\OrderController::class, 'show'])->name('orders.show');
        
        // Analytics
        Route::get('/analytics', function() {
            return view('seller.analytics');
        })->name('analytics');
        
        // Revenue
        Route::get('/revenue', function() {
            return view('seller.revenue');
        })->name('revenue');
        
        // Settings
        Route::get('/settings', [App\Http\Controllers\Seller\SettingsController::class, 'index'])->name('settings');
        Route::put('/settings/shop', [App\Http\Controllers\Seller\SettingsController::class, 'updateShop'])->name('settings.shop');
        Route::put('/settings/account', [App\Http\Controllers\Seller\SettingsController::class, 'updateAccount'])->name('settings.account');
        Route::put('/settings/password', [App\Http\Controllers\Seller\SettingsController::class, 'updatePassword'])->name('settings.password');
    });
});

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Password Reset
    // Password Reset (Direct)
    Route::get('/forgot-password', [AdminPasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [AdminPasswordResetController::class, 'reset'])->name('password.update');
    
    // Admin Panel Routes (Protected)
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', CategoryController::class);
        
        // Seller Management
        Route::get('/sellers', [App\Http\Controllers\Admin\SellerController::class, 'index'])->name('sellers.index');
        Route::get('/sellers/{seller}', [App\Http\Controllers\Admin\SellerController::class, 'show'])->name('sellers.show');
        Route::post('/sellers/{seller}/approve', [App\Http\Controllers\Admin\SellerController::class, 'approve'])->name('sellers.approve');
        Route::post('/sellers/{seller}/reject', [App\Http\Controllers\Admin\SellerController::class, 'reject'])->name('sellers.reject');
        
        // Product Moderation
        Route::get('/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'show'])->name('products.show');
        Route::post('/products/{product}/approve', [App\Http\Controllers\Admin\ProductController::class, 'approve'])->name('products.approve');
        Route::post('/products/{product}/reject', [App\Http\Controllers\Admin\ProductController::class, 'reject'])->name('products.reject');
        Route::delete('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');
        
        // User Management
        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
        Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
        
        // Order Management
        Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        
        
        // Notifications
        Route::get('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    });
});
