@extends('layouts.admin')

@section('page-title', 'Customers')

@section('content')

<div class="glass-card rounded-3xl overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white/50">
        <h3 class="text-lg font-bold text-dark-charcoal flex items-center gap-2">
            <i class="fas fa-users text-primary-cyan"></i>
            Customer Management
        </h3>
        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-bold">
            {{ $users->count() }} Registered
        </span>
    </div>

    @if($users->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Contact Info</th>
                        <th class="px-6 py-4">Joined Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $user)
                        <tr class="group hover:bg-white/60 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 p-[2px] flex-shrink-0">
                                        <div class="w-full h-full rounded-full bg-white flex items-center justify-center text-blue-500 font-bold text-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 group-hover:text-primary-cyan transition-colors">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-400">ID: #{{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 space-y-1">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-envelope text-gray-400 text-xs w-4"></i>
                                        {{ $user->email }}
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-phone text-gray-400 text-xs w-4"></i>
                                        {{ $user->phone ?? 'Not provided' }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-full bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-200 flex items-center justify-center" 
                                            title="Delete Customer"
                                            onclick="return confirm('Are you sure you want to delete this customer? This action cannot be undone.')">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                <i class="fas fa-users text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900">No customers found</h3>
            <p class="text-gray-500">Registered users will appear here.</p>
        </div>
    @endif
</div>

@endsection
