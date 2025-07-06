<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'BN Car Transport') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 min-h-screen p-4">
            <div class="flex items-center mb-8">
                <h2 class="text-xl font-semibold">BN Car Transport</h2>
            </div>
            
            <nav class="space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded px-3 py-2 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2v0"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Services -->
                <a href="{{ route('admin.services.index') }}" 
                   class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded px-3 py-2 {{ request()->routeIs('admin.services.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span>Services</span>
                    @if(\App\Models\Service::where('is_active', true)->count() > 0)
                        <span class="bg-blue-500 text-white text-xs rounded-full px-2 py-1 ml-auto">{{ \App\Models\Service::where('is_active', true)->count() }}</span>
                    @endif
                </a>

                <!-- Quote Requests -->
                <a href="{{ route('admin.quote-requests.index') }}" 
                   class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded px-3 py-2 {{ request()->routeIs('admin.quote-requests.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span>Quote Requests</span>
                    @if(\App\Models\QuoteRequest::where('status', 'pending')->count() > 0)
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-auto">{{ \App\Models\QuoteRequest::where('status', 'pending')->count() }}</span>
                    @endif
                </a>

                <!-- Blog Management -->
                <div class="pt-2">
                    <div class="text-gray-400 text-xs uppercase tracking-wider px-3 py-2">Blog</div>
                    
                    <!-- Blog Posts -->
                    <a href="{{ route('admin.blog-posts.index') }}" 
                       class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded px-3 py-2 {{ request()->routeIs('admin.blog-posts.*') ? 'bg-gray-700 text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <span>Blog Posts</span>
                        @if(\App\Models\BlogPost::where('status', 'published')->count() > 0)
                            <span class="bg-green-500 text-white text-xs rounded-full px-2 py-1 ml-auto">{{ \App\Models\BlogPost::where('status', 'published')->count() }}</span>
                        @endif
                    </a>

                    <!-- Blog Categories -->
                    <a href="{{ route('admin.blog-categories.index') }}" 
                       class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded px-3 py-2 {{ request()->routeIs('admin.blog-categories.*') ? 'bg-gray-700 text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span>Categories</span>
                        @if(\App\Models\BlogCategory::where('is_active', true)->count() > 0)
                            <span class="bg-blue-400 text-white text-xs rounded-full px-2 py-1 ml-auto">{{ \App\Models\BlogCategory::where('is_active', true)->count() }}</span>
                        @endif
                    </a>
                </div>

                <!-- Content Management -->
                <div class="pt-2">
                    <div class="text-gray-400 text-xs uppercase tracking-wider px-3 py-2">Content</div>
                    
                    <!-- Testimonials -->
                    <a href="{{ route('admin.testimonials.index') }}" 
                       class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded px-3 py-2 {{ request()->routeIs('admin.testimonials.*') ? 'bg-gray-700 text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <span>Testimonials</span>
                        @if(\App\Models\Testimonial::where('is_approved', false)->count() > 0)
                            <span class="bg-yellow-500 text-white text-xs rounded-full px-2 py-1 ml-auto">{{ \App\Models\Testimonial::where('is_approved', false)->count() }}</span>
                        @endif
                    </a>

                    <!-- Gallery -->
                    <a href="{{ route('admin.galleries.index') }}" 
                       class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded px-3 py-2 {{ request()->routeIs('admin.galleries.*') ? 'bg-gray-700 text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Gallery</span>
                        @if(\App\Models\Gallery::where('is_active', true)->count() > 0)
                            <span class="bg-purple-500 text-white text-xs rounded-full px-2 py-1 ml-auto">{{ \App\Models\Gallery::where('is_active', true)->count() }}</span>
                        @endif
                    </a>

                    <!-- Pages -->
                    <a href="{{ route('admin.pages.index') }}" 
                       class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded px-3 py-2 {{ request()->routeIs('admin.pages.*') ? 'bg-gray-700 text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Pages</span>
                    </a>
                </div>

                <!-- Settings -->
                <div class="pt-2">
                    <div class="text-gray-400 text-xs uppercase tracking-wider px-3 py-2">System</div>
                    
                    <a href="{{ route('admin.settings.index') }}" 
                       class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded px-3 py-2 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-700 text-white' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Settings</span>
                    </a>
                </div>
            </nav>

            <!-- User Menu -->
            <div class="mt-auto pt-4 border-t border-gray-700">
                <div class="flex items-center space-x-3 text-gray-300 px-3 py-2">
                    <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-white">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-400">Administrator</div>
                    </div>
                </div>
                
                <div class="px-3 py-2 space-y-1">
                    <a href="{{ route('home') }}" target="_blank" 
                       class="block text-sm text-gray-300 hover:text-white">
                        View Website
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="block text-sm text-gray-300 hover:text-white">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-semibold text-gray-900">
                            @yield('page-title', 'Dashboard')
                        </h1>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Quick Stats -->
                            <div class="hidden sm:flex items-center space-x-4 text-sm text-gray-600">
                                <span>{{ \App\Models\QuoteRequest::where('status', 'pending')->count() }} Pending Quotes</span>
                                <span>•</span>
                                <span>{{ \App\Models\Testimonial::where('is_approved', false)->count() }} Unapproved Reviews</span>
                            </div>

                            <!-- Notifications -->
                            <div class="relative">
                                <button class="p-2 text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-12a3 3 0 016 0v12z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 m-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 m-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>