@extends('layouts.admin')

@section('page-title', 'Categories')

@section('content')

<!-- Header Actions -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
    <div>
        <h2 class="text-xl font-bold text-dark-charcoal flex items-center gap-2">
            <i class="fas fa-layer-group text-primary-cyan"></i>
            Manage Categories
        </h2>
        <p class="text-gray-500 text-sm mt-1">Create and manage your product categories.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-primary-cyan to-primary-turquoise text-white font-semibold shadow-lg shadow-primary-cyan/30 hover:shadow-primary-cyan/50 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Add Category</span>
    </a>
</div>

@if($categories->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $index => $category)
            <div class="glass-card p-6 rounded-3xl relative group hover:-translate-y-1 transition-transform duration-300">
                
                <!-- Background Decoration -->
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-primary-cyan/10 to-transparent rounded-bl-full -z-10 group-hover:scale-110 transition-transform duration-300"></div>

                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-dark-charcoal group-hover:text-primary-cyan transition-colors">{{ $category->name }}</h3>
                        <div class="mt-2 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-xs font-mono text-gray-500">
                            <i class="fas fa-link text-[10px]"></i>
                            {{ $category->slug }}
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all duration-300" title="Edit">
                            <i class="fas fa-edit text-xs"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all duration-300" title="Delete" 
                                    onclick="return confirm('Are you sure? This will delete the category and may affect associated products.')">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-gray-500">
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-box text-xs"></i>
                        </div>
                        <span class="text-sm font-medium">{{ $category->products_count ?? 0 }} Products</span>
                    </div>
                    <i class="fas fa-chevron-right text-gray-300 group-hover:text-primary-cyan group-hover:translate-x-1 transition-all duration-300"></i>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="glass-card rounded-3xl p-12 text-center">
        <div class="w-20 h-20 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-6 text-gray-300">
            <i class="fas fa-layer-group text-4xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-700 mb-2">No Categories Yet</h3>
        <p class="text-gray-500 mb-8">Create your first category to start organizing products.</p>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gray-900 text-white font-medium hover:bg-gray-800 transition-colors">
            <i class="fas fa-plus"></i>
            Create Category
        </a>
    </div>
@endif

@endsection
