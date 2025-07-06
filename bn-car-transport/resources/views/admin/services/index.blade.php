@extends('admin.layouts.app')

@section('title', 'Manage Services')
@section('page-title', 'Services')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Services</h2>
                <p class="text-sm text-gray-600">Manage your transportation services</p>
            </div>
            <a href="{{ route('admin.services.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Service
            </a>
        </div>

        <!-- Services Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            @if($services->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($services as $service)
                    <li>
                        <div class="px-4 py-4 flex items-center justify-between">
                            <div class="flex items-center">
                                @if($service->image)
                                    <img class="h-16 w-16 rounded-lg object-cover mr-4" 
                                         src="{{ Storage::url($service->image) }}" 
                                         alt="{{ $service->title }}">
                                @else
                                    <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $service->title }}</h3>
                                        @if($service->is_active)
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Inactive
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($service->description, 100) }}</p>
                                    <div class="flex items-center mt-2 text-sm text-gray-500">
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                            {{ ucfirst(str_replace('_', ' ', $service->service_type)) }}
                                        </span>
                                        @if($service->price_from && $service->price_to)
                                            <span class="text-green-600 font-medium">
                                                ₹{{ number_format($service->price_from) }} - ₹{{ number_format($service->price_to) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <!-- View Button -->
                                <a href="{{ route('admin.services.show', $service) }}" 
                                   class="text-gray-400 hover:text-gray-600" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('admin.services.edit', $service) }}" 
                                   class="text-blue-400 hover:text-blue-600" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <!-- Toggle Status Button -->
                                <form action="{{ route('admin.services.toggle-status', $service) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="text-{{ $service->is_active ? 'yellow' : 'green' }}-400 hover:text-{{ $service->is_active ? 'yellow' : 'green' }}-600" 
                                            title="{{ $service->is_active ? 'Deactivate' : 'Activate' }}">
                                        @if($service->is_active)
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                    </button>
                                </form>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this service?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>

                <!-- Pagination -->
                @if($services->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $services->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No services</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new service.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.services.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Service
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection