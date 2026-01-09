@extends('layouts.admin')

@section('title', 'Admin Login')

@section('content')
<style>
    .login-container { max-width: 400px; margin: 5rem auto; }
    .login-card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    .login-header { text-align: center; margin-bottom: 2rem; }
    .login-header h2 { color: #2d3748; margin-bottom: 0.5rem; }
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; color: #4a5568; font-weight: 500; }
    .form-control { width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 5px; font-size: 1rem; }
    .form-control:focus { outline: none; border-color: #667eea; }
    .error { color: #f56565; font-size: 0.875rem; margin-top: 0.25rem; }
    .btn-login { width: 100%; padding: 0.75rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 5px; font-size: 1rem; font-weight: 600; cursor: pointer; }
    .btn-login:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4); }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h2>🏛️ Admin Login</h2>
            <p style="color: #718096;">Access the admin panel</p>
        </div>

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
</div>
@endsection
