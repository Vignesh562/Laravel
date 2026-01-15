@extends('layouts.admin')

@section('page-title', 'Edit Category')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.categories.index') }}" style="color: #667eea; text-decoration: none; font-weight: 600;">
            ← Back to Categories
        </a>
    </div>

    <div class="card">
        <h2 style="font-size: 1.75rem; font-weight: 800; color: #1e293b; margin-bottom: 2rem;">Edit Category</h2>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.75rem; color: #1e293b; font-weight: 700; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    Category Name
                </label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name', $category->name) }}" 
                    style="width: 100%; padding: 1rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; transition: all 0.3s; font-weight: 500;"
                    placeholder="e.g., Electronics, Plumbing, etc."
                    required
                    onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 4px rgba(102, 126, 234, 0.1)'"
                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                >
                @error('name')
                    <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        ⚠️ {{ $message }}
                    </span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.75rem; color: #1e293b; font-weight: 700; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    Icon (Emoji)
                </label>
                <input 
                    type="text" 
                    name="icon" 
                    value="{{ old('icon', $category->icon) }}" 
                    style="width: 100%; padding: 1rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 2rem; transition: all 0.3s; font-weight: 500; text-align: center;"
                    placeholder="⚡"
                    maxlength="10"
                    required
                    onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 4px rgba(102, 126, 234, 0.1)'"
                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                >
                <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.5rem;">
                    Use a single emoji to represent this category
                </p>
                @error('icon')
                    <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        ⚠️ {{ $message }}
                    </span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.75rem; color: #1e293b; font-weight: 700; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                    Description (Optional)
                </label>
                <textarea 
                    name="description" 
                    rows="4"
                    style="width: 100%; padding: 1rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; transition: all 0.3s; font-weight: 500; resize: vertical;"
                    placeholder="Describe this category..."
                    onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 4px rgba(102, 126, 234, 0.1)'"
                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                >{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        ⚠️ {{ $message }}
                    </span>
                @enderror
            </div>

            <div style="background: #f8fafc; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">
                <p style="color: #64748b; font-size: 0.875rem; font-weight: 600;">
                    <strong>Current Slug:</strong> <code style="background: white; padding: 0.25rem 0.5rem; border-radius: 6px; font-family: monospace;">{{ $category->slug }}</code>
                </p>
                <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.5rem;">
                    The slug will be automatically updated based on the category name.
                </p>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Update Category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn" style="flex: 1; background: #e2e8f0; color: #475569; text-align: center; line-height: 1.5;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
