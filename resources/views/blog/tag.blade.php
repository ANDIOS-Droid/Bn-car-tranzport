@extends('layouts.app')

@section('title', 'Posts tagged with "' . $tag . '" - Blog')
@section('meta_description', 'Browse all blog posts tagged with "' . $tag . '" - expert tips and guides for vehicle transportation.')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <div class="mb-4">
                <span class="inline-block px-4 py-2 bg-purple-500 rounded-full text-sm font-semibold">
                    <i class="fas fa-tag mr-2"></i>
                    Tag
                </span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                #{{ $tag }}
            </h1>
            <p class="text-xl text-purple-100 mb-8">
                Discover all articles tagged with "{{ $tag }}"
            </p>
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
            <span class="text-gray-900 font-medium">Tag: {{ $tag }}</span>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <!-- Results Info -->
            <div class="mb-8">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        Articles tagged with "{{ $tag }}"
                    </h2>
                    <p class="text-gray-600">
                        Found {{ $posts->total() }} {{ Str::plural('article', $posts->total()) }} with this tag
                    </p>
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
                                            @foreach($post->tags as $postTag)
                                                <a 
                                                    href="{{ route('blog.tag', $postTag) }}" 
                                                    class="text-xs px-2 py-1 rounded transition duration-300 {{ $postTag === $tag ? 'bg-purple-100 text-purple-600 font-semibold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                                                >
                                                    #{{ $postTag }}
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
                            <i class="fas fa-tag text-6xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No articles found</h3>
                        <p class="text-gray-600 mb-4">
                            No articles have been tagged with "{{ $tag }}" yet.
                        </p>
                        <a href="{{ route('blog.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            Browse All Articles
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="mt-12">
                    {{ $posts->appends(['tag' => $tag])->links() }}
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/3">
            <div class="space-y-8">
                <!-- Related Tags -->
                @if($allTags->count() > 1)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($allTags->reject(function($t) use ($tag) { return $t === $tag; })->take(15) as $relatedTag)
                                <a 
                                    href="{{ route('blog.tag', $relatedTag) }}" 
                                    class="text-xs px-3 py-1 bg-gray-100 text-gray-600 rounded-full hover:bg-purple-100 hover:text-purple-600 transition duration-300"
                                >
                                    #{{ $relatedTag }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Categories -->
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

                <!-- Recent Posts -->
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

                <!-- Back to Blog -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold mb-2">Explore More</h3>
                    <p class="text-blue-100 text-sm mb-4">Discover more articles and transportation tips.</p>
                    <a 
                        href="{{ route('blog.index') }}" 
                        class="inline-block bg-white text-blue-600 px-4 py-2 rounded font-semibold text-sm hover:bg-gray-100 transition duration-300"
                    >
                        Browse All Articles
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection