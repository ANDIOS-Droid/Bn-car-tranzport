@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Services Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Active Services</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['active_services'] }}/{{ $stats['total_services'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.services.index') }}" class="font-medium text-blue-700 hover:text-blue-900">Manage services</a>
                    </div>
                </div>
            </div>

            <!-- Quote Requests Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Quote Requests</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['pending_quotes'] }}/{{ $stats['total_quote_requests'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.quote-requests.index') }}" class="font-medium text-yellow-700 hover:text-yellow-900">View requests</a>
                    </div>
                </div>
            </div>

            <!-- Testimonials Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Testimonials</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['approved_testimonials'] }}/{{ $stats['total_testimonials'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.testimonials.index') }}" class="font-medium text-green-700 hover:text-green-900">Manage testimonials</a>
                    </div>
                </div>
            </div>

            <!-- Gallery Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Gallery Images</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['total_gallery_images'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.galleries.index') }}" class="font-medium text-purple-700 hover:text-purple-900">Manage gallery</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Quote Requests -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Quote Requests</h3>
                    <div class="flow-root">
                        @if($recent_quotes->count() > 0)
                            <ul class="-mb-8">
                                @foreach($recent_quotes as $index => $quote)
                                <li class="{{ $index < $recent_quotes->count() - 1 ? 'pb-3 border-b' : '' }}">
                                    <div class="relative pb-3">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-{{ $quote->status === 'pending' ? 'yellow' : ($quote->status === 'quoted' ? 'blue' : 'green') }}-500 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div>
                                                    <div class="text-sm">
                                                        <a href="{{ route('admin.quote-requests.show', $quote) }}" class="font-medium text-gray-900">{{ $quote->name }}</a>
                                                    </div>
                                                    <p class="mt-0.5 text-sm text-gray-500">
                                                        {{ $quote->pickup_city }} → {{ $quote->delivery_city }}
                                                    </p>
                                                    <p class="mt-0.5 text-xs text-gray-400">
                                                        {{ $quote->transport_type }} • {{ ucfirst($quote->status) }}
                                                    </p>
                                                </div>
                                                <div class="mt-2 text-sm text-gray-700">
                                                    <p>{{ $quote->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500">No recent quote requests.</p>
                        @endif
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('admin.quote-requests.index') }}" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            View all quote requests
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Testimonials -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Testimonials</h3>
                    <div class="flow-root">
                        @if($recent_testimonials->count() > 0)
                            <ul class="-mb-8">
                                @foreach($recent_testimonials as $index => $testimonial)
                                <li class="{{ $index < $recent_testimonials->count() - 1 ? 'pb-3 border-b' : '' }}">
                                    <div class="relative pb-3">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div>
                                                    <div class="text-sm">
                                                        <a href="{{ route('admin.testimonials.show', $testimonial) }}" class="font-medium text-gray-900">{{ $testimonial->name }}</a>
                                                    </div>
                                                    <p class="mt-0.5 text-sm text-gray-500">
                                                        <span class="flex items-center">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                @if($i <= $testimonial->rating)
                                                                    <svg class="h-3 w-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                    </svg>
                                                                @else
                                                                    <svg class="h-3 w-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                    </svg>
                                                                @endif
                                                            @endfor
                                                            <span class="ml-1 text-xs">{{ $testimonial->rating }}/5</span>
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="mt-2 text-sm text-gray-700">
                                                    <p class="line-clamp-2">{{ Str::limit($testimonial->message, 100) }}</p>
                                                </div>
                                                <div class="mt-2 text-xs text-gray-400">
                                                    {{ $testimonial->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500">No recent testimonials.</p>
                        @endif
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('admin.testimonials.index') }}" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            View all testimonials
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quote Status Overview -->
        @if(!empty($quote_status_breakdown))
        <div class="mt-8 bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quote Status Overview</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach(['pending', 'reviewed', 'quoted', 'accepted', 'rejected', 'completed'] as $status)
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $quote_status_breakdown[$status] ?? 0 }}</div>
                            <div class="text-sm text-gray-500 capitalize">{{ $status }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection