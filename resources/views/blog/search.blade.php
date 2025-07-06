@extends('layouts.app')

@section('title', 'Search Results for "' . $searchTerm . '" - Blog')
@section('meta_description', 'Search results for "' . $searchTerm . '" in our transportation blog - find expert tips and guides.')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-green-600 to-green-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <div class="mb-4">
                <span class="inline-block px-4 py-2 bg-green-500 rounded-full text-sm font-semibold">
                    <i class="fas fa-search mr-2"></i>
                    Search Results
                </span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                "{{ $searchTerm }}"
            </h1>
            <p class="text-xl text-green-100 mb-8">
                @if($posts->total() > 0)
                    Found {{ $posts->total() }} {{ Str::plural('result', $posts->total()) }} for your search
                @else
                    No results found for your search
                @endif
            </p>
            
            <!-- Search Form -->
            <div class="max-w-lg mx-auto">
                <form action="{{ route('blog.search') }}" method="GET" class="flex">
                    <input 
                        type="text" 
                        name="q" 
                        placeholder="Search articles..." 
                        value="{{ $searchTerm }}"
                        class="flex-1 px-4 py-3 rounded-l-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-300"
                        autofocus
                    >
                    <button type="submit" class="bg-green-500 hover:bg-green-400 px-6 py-3 rounded-r-lg transition duration-300">
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
            <a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-blue-600">Blog</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-900 font-medium">Search: "{{ $searchTerm }}"</span>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <!-- Search Info -->
            <div class="mb-8">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        Search Results for "{{ $searchTerm }}"
                    </h2>
                    <p class="text-gray-600">
                        @if($posts->total() > 0)
                            Showing {{ $posts->firstItem() }}-{{ $posts->lastItem() }} of {{ $posts->total() }} results
                        @else
                            No articles found matching your search criteria
                        @endif
                    </p>
                </div>
            </div>

            <!-- Search Suggestions -->
            @if($posts->total() === 0)
                <div class="mb-8">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-3">
                            <i class="fas fa-lightbulb mr-2"></i>
                            Search Tips
                        </h3>
                        <ul class="text-blue-800 space-y-2">
                            <li>• Try using different keywords or synonyms</li>
                            <li>• Check your spelling</li>
                            <li>• Use fewer words for broader results</li>
                            <li>• Try searching for more general terms</li>
                        </ul>
                        
                        <div class="mt-4">
                            <h4 class="font-semibold text-blue-900 mb-2">Popular topics:</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach(['car transport', 'bike transport', 'vehicle shipping', 'transport tips', 'safety'] as $suggestion)
                                    <a 
                                        href="{{ route('blog.search', ['q' => $suggestion]) }}" 
                                        class="text-xs px-3 py-1 bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition duration-300"
                                    >
                                        {{ $suggestion }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Search Results -->
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
                                    <a href="{{ route('blog.show', $post->slug) }}">
                                        {!! highlightSearchTerm($post->title, $searchTerm) !!}
                                    </a>
                                </h2>
                                
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {!! highlightSearchTerm($post->excerpt, $searchTerm) !!}
                                </p>
                                
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
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No results found</h3>
                        <p class="text-gray-600 mb-6">
                            We couldn't find any articles matching "{{ $searchTerm }}". Try using different keywords or browse our categories below.
                        </p>
                        <div class="flex flex-wrap justify-center gap-3">
                            <a 
                                href="{{ route('blog.index') }}" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-300"
                            >
                                Browse All Articles
                            </a>
                            <a 
                                href="{{ route('services') }}" 
                                class="border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-6 py-3 rounded-lg font-semibold transition duration-300"
                            >
                                Our Services
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="mt-12">
                    {{ $posts->appends(['q' => $searchTerm])->links() }}
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/3">
            <div class="space-y-8">
                <!-- Advanced Search -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Refine Your Search</h3>
                    <form action="{{ route('blog.search') }}" method="GET" class="space-y-4">
                        <div>
                            <label for="q" class="block text-sm font-medium text-gray-700 mb-1">Search Terms</label>
                            <input 
                                type="text" 
                                name="q" 
                                id="q"
                                value="{{ $searchTerm }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter keywords..."
                            >
                        </div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg transition duration-300">
                            <i class="fas fa-search mr-2"></i>
                            Search Again
                        </button>
                    </form>
                </div>

                <!-- Search by Categories -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Browse by Category</h3>
                    <ul class="space-y-2">
                        @foreach($categories as $category)
                            <li>
                                <a 
                                    href="{{ route('blog.category', $category->slug) }}" 
                                    class="flex items-center justify-between p-2 rounded hover:bg-gray-50 transition duration-300 text-gray-700"
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

                <!-- Popular Tags -->
                @if($allTags->count() > 0)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Popular Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($allTags->take(15) as $tag)
                                <a 
                                    href="{{ route('blog.tag', $tag) }}" 
                                    class="text-xs px-3 py-1 bg-gray-100 text-gray-600 rounded-full hover:bg-green-100 hover:text-green-600 transition duration-300"
                                >
                                    #{{ $tag }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Popular Articles -->
                @if($recentPosts->count() > 0)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Popular Articles</h3>
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

                <!-- Help Section -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2">Need Help?</h3>
                    <p class="text-blue-100 text-sm mb-4">Can't find what you're looking for? Our team is here to help.</p>
                    <a 
                        href="{{ route('contact') }}" 
                        class="inline-block bg-white text-blue-600 px-4 py-2 rounded font-semibold text-sm hover:bg-gray-100 transition duration-300"
                    >
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

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
    
    .highlight {
        background-color: #fef08a;
        font-weight: 600;
        padding: 0 2px;
        border-radius: 2px;
    }
</style>
@endpush

@php
    function highlightSearchTerm($text, $term) {
        if (empty(trim($term))) return $text;
        
        return preg_replace(
            '/(' . preg_quote(trim($term), '/') . ')/i',
            '<span class="highlight">$1</span>',
            $text
        );
    }
@endphp
@endsection