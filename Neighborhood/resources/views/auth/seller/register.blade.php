@extends('layouts.seller')

@section('title', 'Seller Registration')

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 50%, #06b6d4 100%);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    @keyframes gradientBG {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    
    .register-container {
        width: 100%;
        max-width: 580px;
        padding: 2rem;
        animation: fadeInUp 0.8s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .register-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        padding: 3rem;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.18);
        position: relative;
        overflow: hidden;
    }
    
    .register-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #0ea5e9 0%, #06b6d4 100%);
    }
    
    .register-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    
    .register-header .icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        animation: bounce 2s ease-in-out infinite;
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .register-header h2 {
        font-size: 2rem;
        font-weight: 900;
        background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }
    
    .register-header p {
        color: #64748b;
        font-weight: 500;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.75rem;
        color: #1e293b;
        font-weight: 700;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-control {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s;
        background: white;
        font-weight: 500;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        transform: translateY(-2px);
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
    
    .error {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-register {
        width: 100%;
        padding: 1.125rem;
        background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.125rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.4);
        position: relative;
        overflow: hidden;
        margin-top: 1rem;
    }
    
    .btn-register::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .btn-register:hover::before {
        width: 400px;
        height: 400px;
    }
    
    .btn-register:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(14, 165, 233, 0.5);
    }
    
    .divider {
        text-align: center;
        margin: 2rem 0;
        position: relative;
    }
    
    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e2e8f0;
    }
    
    .divider span {
        background: rgba(255, 255, 255, 0.95);
        padding: 0 1rem;
        color: #64748b;
        font-weight: 600;
        position: relative;
        z-index: 1;
    }
    
    .login-link {
        text-align: center;
        margin-top: 2rem;
        color: #475569;
        font-weight: 500;
    }
    
    .login-link a {
        color: #0ea5e9;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .login-link a:hover {
        color: #0369a1;
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <div class="icon">🚀</div>
            <h2>Become a Seller</h2>
            <p>Start selling in your neighborhood today</p>
        </div>

        <form method="POST" action="{{ route('seller.register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Your Full Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control" 
                    value="{{ old('name') }}" 
                    placeholder="John Doe"
                    required 
                    autofocus
                >
                @error('name')
                    <span class="error">⚠️ {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    value="{{ old('email') }}" 
                    placeholder="seller@example.com"
                    required
                >
                @error('email')
                    <span class="error">⚠️ {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    class="form-control" 
                    value="{{ old('phone') }}" 
                    placeholder="+91 98765 43210"
                    required
                >
                @error('phone')
                    <span class="error">⚠️ {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="shop_name">Shop Name</label>
                <input 
                    type="text" 
                    id="shop_name" 
                    name="shop_name" 
                    class="form-control" 
                    value="{{ old('shop_name') }}" 
                    placeholder="My Awesome Shop"
                    required
                >
                @error('shop_name')
                    <span class="error">⚠️ {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="shop_description">Shop Description (Optional)</label>
                <textarea 
                    id="shop_description" 
                    name="shop_description" 
                    class="form-control" 
                    placeholder="Tell customers about your shop and products..."
                >{{ old('shop_description') }}</textarea>
                @error('shop_description')
                    <span class="error">⚠️ {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    placeholder="Min. 8 characters"
                    required
                >
                @error('password')
                    <span class="error">⚠️ {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-control" 
                    placeholder="Re-enter password"
                    required
                >
            </div>

            <button type="submit" class="btn-register">Register My Shop</button>
        </form>

        <div class="divider">
            <span>OR</span>
        </div>

        <div class="login-link">
            Already have a seller account? <a href="{{ route('seller.login') }}">Sign in here</a>
        </div>
    </div>
</div>
@endsection
