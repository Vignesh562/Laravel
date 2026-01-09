@extends('layouts.seller')

@section('title', 'Seller Login')

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
    
    .login-container {
        width: 100%;
        max-width: 480px;
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
    
    .login-card {
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
    
    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #0ea5e9 0%, #06b6d4 100%);
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    
    .login-header .icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        animation: bounce 2s ease-in-out infinite;
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .login-header h2 {
        font-size: 2rem;
        font-weight: 900;
        background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }
    
    .login-header p {
        color: #64748b;
        font-weight: 500;
    }
    
    .form-group {
        margin-bottom: 1.75rem;
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
    
    .error {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 1.5rem 0;
    }
    
    .checkbox-group input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }
    
    .checkbox-group label {
        margin: 0;
        color: #475569;
        font-weight: 500;
        cursor: pointer;
    }
    
    .btn-login {
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
    }
    
    .btn-login::before {
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
    
    .btn-login:hover::before {
        width: 400px;
        height: 400px;
    }
    
    .btn-login:hover {
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
    
    .register-link {
        text-align: center;
        margin-top: 2rem;
        color: #475569;
        font-weight: 500;
    }
    
    .register-link a {
        color: #0ea5e9;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .register-link a:hover {
        color: #0369a1;
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="icon">🏪</div>
            <h2>Seller Login</h2>
            <p>Access your seller dashboard</p>
        </div>

        <form method="POST" action="{{ route('seller.login') }}">
            @csrf

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
                    autofocus
                >
                @error('email')
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
                    placeholder="Enter your password"
                    required
                >
                @error('password')
                    <span class="error">⚠️ {{ $message }}</span>
                @enderror
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me for 30 days</label>
            </div>

            <button type="submit" class="btn-login">Sign In to Dashboard</button>
        </form>

        <div class="divider">
            <span>OR</span>
        </div>

        <div class="register-link">
            Want to become a seller? <a href="{{ route('seller.register') }}">Register your shop</a>
        </div>
    </div>
</div>
@endsection
