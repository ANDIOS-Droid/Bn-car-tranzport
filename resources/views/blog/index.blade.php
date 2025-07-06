@extends('layouts.app')

@section('title', 'Blog & Transportation Tips')
@section('meta_description', 'Expert tips, guides, and news about car and bike transportation. Stay updated with the latest industry trends and helpful advice.')
@section('meta_keywords', 'transport blog, car transport tips, bike transport guide, vehicle shipping news, transportation advice')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Transportation Blog & Tips
            </h1>
            <p class="text-xl text-blue-100 mb-8">
                Expert advice, industry insights, and helpful guides for vehicle transportation
            </p>
            
            <!-- Search Bar -->
            <div class="max-w-md mx-auto">
                <form action="{{ route('blog.search') }}" method="GET" class="flex">
                    <input 
                        type="text" 
                        name="q" 
                        placeholder="Search articles..." 
                        value="{{ request('search') }}"
                        class="flex-1 px-4 py-3 rounded-l-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-300"
                    >
                    <button type="submit" class="bg-blue-500 hover:bg-blue-400 px-6 py-3 rounded-r-lg transition duration-300">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Breadcrumbs -->
<div class="bg-gray-50 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex text-sm">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            @if($currentCategory)
                <a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-blue-600">Blog</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-900 font-medium">{{ $currentCategory->name }}</span>
            @else
                <span class="text-gray-900 font-medium">Blog</span>
            @endif
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <!-- Featured Posts -->
            @if($featuredPosts->count() > 0 && !request()->filled('category') && !request()->filled('tag') && !request()->filled('search'))
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Featured Articles</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($featuredPosts as $post)
                            <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                                @if($post->featured_image_url)
                                    <div class="aspect-w-16 aspect-h-9">
                                        <img 
                                            src="{{ $post->featured_image_url }}" 
                                            alt="{{ $post->title }}"
                                            class="w-full h-48 object-cover"
                                        >
                                    </div>
                                @endif
                                
                                <div class="p-6">
                                    @if($post->category)
                                        <div class="mb-2">
                                            <a 
                                                href="{{ route('blog.category', $post->category->slug) }}" 
                                                class="inline-block px-3 py-1 text-xs font-semibold rounded-full"
                                                style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }}"
                                            >
                                                {{ $post->category->name }}
                                            </a>
                                        </div>
                                    @endif
                                    
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 hover:text-blue-600 transition duration-300">
                                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                    </h3>
                                    
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $post->excerpt }}</p>
                                    
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <div class="flex items-center space-x-4">
                                            <span><i class="fas fa-calendar mr-1"></i>{{ $post->formatted_published_date }}</span>
                                            <span><i class="fas fa-clock mr-1"></i>{{ $post->reading_time }}</span>
                                        </div>
                                        <span><i class="fas fa-eye mr-1"></i>{{ $post->views_count }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Category Filter -->
            @if($currentCategory)
                <div class="mb-8">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $currentCategory->name }}</h2>
                                <p class="text-gray-600 mt-1">{{ $currentCategory->description }}</p>
                            </div>
                            <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background-color: {{ $currentCategory->color }}20">
                                <i class="fas fa-tag text-2xl" style="color: {{ $currentCategory->color }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filter Bar -->
            <div class="mb-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700 font-medium">Filter by:</span>
                        <select onchange="window.location.href = this.value" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="{{ route('blog.index') }}">All Categories</option>
                            @foreach($categories as $category)
                                <option 
                                    value="{{ route('blog.category', $category->slug) }}"
                                    {{ request()->route('slug') === $category->slug ? 'selected' : '' }}
                                >
                                    {{ $category->name }} ({{ $category->published_blog_posts_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="text-sm text-gray-600">
                        Showing {{ $posts->firstItem() ?? 0 }} - {{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }} articles
                    </div>
                </div>
            </div>

            <!-- Blog Posts -->
            <div class="space-y-8">
                @forelse($posts as $post)
                    <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                        <div class="md:flex">
                            @if($post->featured_image_url)
                                <div class="md:w-1/3">
                                    <img 
                                        src="{{ $post->featured_image_url }}" 
                                        alt="{{ $post->title }}"
                                        class="w-full h-64 md:h-full object-cover"
                                    >
                                </div>
                            @endif
                            
                            <div class="p-6 {{ $post->featured_image_url ? 'md:w-2/3' : 'w-full' }}">
                                @if($post->category)
                                    <div class="mb-3">
                                        <a 
                                            href="{{ route('blog.category', $post->category->slug) }}" 
                                            class="inline-block px-3 py-1 text-xs font-semibold rounded-full hover:opacity-80 transition duration-300"
                                            style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }}"
                                        >
                                            {{ $post->category->name }}
                                        </a>
                                    </div>
                                @endif
                                
                                <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 hover:text-blue-600 transition duration-300">
                                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                </h2>
                                
                                <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                                
                                <!-- Tags -->
                                @if($post->tags && count($post->tags) > 0)
                                    <div class="mb-4">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach(array_slice($post->tags, 0, 3) as $tag)
                                                <a 
                                                    href="{{ route('blog.tag', $tag) }}" 
                                                    class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition duration-300"
                                                >
                                                    #{{ $tag }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span class="flex items-center">
                                            <i class="fas fa-user mr-1"></i>
                                            {{ $post->author->name }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $post->formatted_published_date }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $post->reading_time }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span class="flex items-center">
                                            <i class="fas fa-eye mr-1"></i>
                                            {{ $post->views_count }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-heart mr-1"></i>
                                            {{ $post->likes_count }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <a 
                                        href="{{ route('blog.show', $post->slug) }}" 
                                        class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition duration-300"
                                    >
                                        Read More 
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="text-center py-12">
                        <div class="w-24 h-24 mx-auto mb-4 text-gray-400">
                            <i class="fas fa-search text-6xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No articles found</h3>
                        <p class="text-gray-600 mb-4">
                            @if(request()->filled('search'))
                                We couldn't find any articles matching "{{ request('search') }}".
                            @elseif($currentCategory)
                                No articles found in "{{ $currentCategory->name }}" category.
                            @else
                                No articles have been published yet.
                            @endif
                        </p>
                        <a href="{{ route('blog.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            View All Articles
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/3">
            <div class="space-y-8">
                <!-- Search Widget -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Search Articles</h3>
                    <form action="{{ route('blog.search') }}" method="GET">
                        <div class="flex">
                            <input 
                                type="text" 
                                name="q" 
                                placeholder="Search..." 
                                value="{{ request('q') }}"
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-l-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-lg transition duration-300">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Categories Widget -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Categories</h3>
                    <ul class="space-y-2">
                        @foreach($categories as $category)
                            <li>
                                <a 
                                    href="{{ route('blog.category', $category->slug) }}" 
                                    class="flex items-center justify-between p-2 rounded hover:bg-gray-50 transition duration-300 {{ request()->route('slug') === $category->slug ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}"
                                >
                                    <div class="flex items-center space-x-3">
                                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $category->color }}"></div>
                                        <span>{{ $category->name }}</span>
                                    </div>
                                    <span class="text-sm text-gray-500">({{ $category->published_blog_posts_count }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Recent Posts Widget -->
                @if($recentPosts->count() > 0)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Articles</h3>
                        <div class="space-y-4">
                            @foreach($recentPosts as $recentPost)
                                <div class="flex space-x-3">
                                    @if($recentPost->featured_image_url)
                                        <img 
                                            src="{{ $recentPost->featured_image_url }}" 
                                            alt="{{ $recentPost->title }}"
                                            class="w-16 h-16 object-cover rounded-lg"
                                        >
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-file-alt text-gray-400"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 hover:text-blue-600 transition duration-300 line-clamp-2">
                                            <a href="{{ route('blog.show', $recentPost->slug) }}">{{ $recentPost->title }}</a>
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">{{ $recentPost->published_ago }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Popular Posts Widget -->
                @if($popularPosts->count() > 0)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Popular Articles</h3>
                        <div class="space-y-4">
                            @foreach($popularPosts as $index => $popularPost)
                                <div class="flex space-x-3">
                                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                                        {{ $index + 1 }}
                                    </div>
                                    
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 hover:text-blue-600 transition duration-300 line-clamp-2">
                                            <a href="{{ route('blog.show', $popularPost->slug) }}">{{ $popularPost->title }}</a>
                                        </h4>
                                        <div class="flex items-center space-x-3 mt-1 text-xs text-gray-500">
                                            <span><i class="fas fa-eye mr-1"></i>{{ $popularPost->views_count }}</span>
                                            <span><i class="fas fa-heart mr-1"></i>{{ $popularPost->likes_count }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Tags Cloud -->
                @if($allTags->count() > 0)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Popular Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($allTags->take(20) as $tag)
                                <a 
                                    href="{{ route('blog.tag', $tag) }}" 
                                    class="text-xs px-3 py-1 bg-gray-100 text-gray-600 rounded-full hover:bg-blue-100 hover:text-blue-600 transition duration-300"
                                >
                                    #{{ $tag }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Newsletter Signup -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2">Stay Updated</h3>
                    <p class="text-blue-100 text-sm mb-4">Get the latest transport tips and industry news delivered to your inbox.</p>
                    <form class="space-y-3">
                        <input 
                            type="email" 
                            placeholder="Your email address" 
                            class="w-full px-3 py-2 rounded text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                        >
                        <button type="submit" class="w-full bg-white text-blue-600 py-2 rounded font-semibold text-sm hover:bg-gray-100 transition duration-300">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush