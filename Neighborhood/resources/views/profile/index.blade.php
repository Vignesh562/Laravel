@extends('layouts.user')

@section('page-title', 'My Profile')

@section('content')
<style>
    .profile-container {
        max-width: 1000px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--dark-charcoal);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-title i {
        color: var(--primary-cyan);
    }

    .profile-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 2.5rem;
        box-shadow: var(--shadow-md);
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark-charcoal);
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--gray-200);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: var(--primary-cyan);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .form-grid.full {
        grid-template-columns: 1fr;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
        padding: 2rem;
        background: linear-gradient(135deg, rgba(19, 200, 236, 0.1), rgba(19, 236, 200, 0.1));
        border-radius: var(--radius-xl);
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--primary-cyan), var(--primary-turquoise));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
        font-weight: 800;
        flex-shrink: 0;
    }

    .profile-info h2 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--dark-charcoal);
        margin-bottom: 0.5rem;
    }

    .profile-info p {
        color: var(--gray-600);
        margin: 0;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .form-actions {
            flex-direction: column;
        }
    }
</style>

<div class="profile-container">
    <h1 class="page-title fade-in">
        <i class="fas fa-user-circle"></i>
        My Profile
    </h1>

    <!-- Profile Header -->
    <div class="profile-card slide-in-left">
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="profile-info">
                <h2>{{ Auth::user()->name }}</h2>
                <p><i class="fas fa-envelope"></i> {{ Auth::user()->email }}</p>
                <p><i class="fas fa-calendar"></i> Member since {{ Auth::user()->created_at->format('M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Personal Information -->
    <div class="profile-card slide-in-right">
        <div class="section-title">
            <i class="fas fa-user-edit"></i>
            Personal Information
        </div>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone', Auth::user()->phone) }}">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-grid full">
                <div class="form-group">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="3">{{ old('address', Auth::user()->address) }}</textarea>
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Save Changes
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Change Password -->
    <div class="profile-card slide-in-left">
        <div class="section-title">
            <i class="fas fa-lock"></i>
            Change Password
        </div>

        <form action="{{ route('profile.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid full">
                <div class="form-group">
                    <label class="form-label">Current Password *</label>
                    <input type="password" name="current_password" class="form-control" required>
                    @error('current_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">New Password *</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm New Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            
        </form>
    </div>
</div>
@endsection
