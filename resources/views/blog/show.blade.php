@extends('layouts.app')

@section('title', $post->meta_title ?: $post->title)
@section('meta_description', $post->meta_description)
@section('meta_keywords', $post->meta_keywords)
@section('canonical', $post->canonical_url ?: url()->current())

@section('og_title', $post->og_title ?: $post->title)
@section('og_description', $post->og_description)
@section('og_image', $post->og_image_url ?: $post->featured_image_url)

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white py-16">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <nav class="mb-8">
            <div class="flex text-sm text-gray-300">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('blog.index') }}" class="hover:text-white">Blog</a>
                @if($post->category)
                    <span class="mx-2">/</span>
                    <a href="{{ route('blog.category', $post->category->slug) }}" class="hover:text-white">
                        {{ $post->category->name }}
                    </a>
                @endif
                <span class="mx-2">/</span>
                <span class="text-gray-400">{{ $post->title }}</span>
            </div>
        </nav>

        <div class="max-w-4xl mx-auto">
            <!-- Category Badge -->
            @if($post->category)
                <div class="mb-4">
                    <a 
                        href="{{ route('blog.category', $post->category->slug) }}" 
                        class="inline-block px-4 py-2 text-sm font-semibold rounded-full transition duration-300 hover:opacity-80"
                        style="background-color: {{ $post->category->color }}; color: white;"
                    >
                        {{ $post->category->name }}
                    </a>
                </div>
            @endif

            <!-- Title -->
            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
                {{ $post->title }}
            </h1>

            <!-- Excerpt -->
            @if($post->excerpt)
                <p class="text-xl text-gray-300 leading-relaxed mb-8">
                    {{ $post->excerpt }}
                </p>
            @endif

            <!-- Meta Information -->
            <div class="flex flex-wrap items-center gap-6 text-gray-300">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-user"></i>
                    <span>{{ $post->author->name }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar"></i>
                    <span>{{ $post->formatted_published_date }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-clock"></i>
                    <span>{{ $post->reading_time }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-eye"></i>
                    <span id="viewsCount">{{ $post->views_count }}</span> views
                </div>
                @if($post->tags && count($post->tags) > 0)
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-tags"></i>
                        <div class="flex flex-wrap gap-1">
                            @foreach(array_slice($post->tags, 0, 3) as $tag)
                                <a 
                                    href="{{ route('blog.tag', $tag) }}" 
                                    class="text-xs px-2 py-1 bg-gray-700 text-gray-300 rounded hover:bg-gray-600 transition duration-300"
                                >
                                    #{{ $tag }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Article Content -->
        <article class="lg:w-2/3">
            <!-- Featured Image -->
            @if($post->featured_image_url)
                <div class="mb-8">
                    <img 
                        src="{{ $post->featured_image_url }}" 
                        alt="{{ $post->title }}"
                        class="w-full rounded-lg shadow-lg"
                    >
                </div>
            @endif

            <!-- Article Body -->
            <div class="prose prose-lg max-w-none mb-8">
                <div class="text-gray-700 leading-relaxed">
                    {!! $post->content !!}
                </div>
            </div>

            <!-- Gallery -->
            @if($post->gallery && count($post->gallery) > 0)
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Gallery</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($post->gallery_urls as $image)
                            <img 
                                src="{{ $image }}" 
                                alt="Gallery image"
                                class="w-full h-48 object-cover rounded-lg shadow cursor-pointer hover:shadow-lg transition duration-300"
                                onclick="openImageModal('{{ $image }}')"
                            >
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Tags -->
            @if($post->tags && count($post->tags) > 0)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <a 
                                href="{{ route('blog.tag', $tag) }}" 
                                class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-blue-100 hover:text-blue-600 transition duration-300"
                            >
                                #{{ $tag }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Social Sharing -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Share this article</h3>
                <div class="flex items-center space-x-4">
                    <button 
                        onclick="shareOnFacebook()" 
                        class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300"
                    >
                        <i class="fab fa-facebook-f"></i>
                        <span>Facebook</span>
                    </button>
                    <button 
                        onclick="shareOnTwitter()" 
                        class="flex items-center space-x-2 px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition duration-300"
                    >
                        <i class="fab fa-twitter"></i>
                        <span>Twitter</span>
                    </button>
                    <button 
                        onclick="shareOnLinkedIn()" 
                        class="flex items-center space-x-2 px-4 py-2 bg-blue-800 text-white rounded-lg hover:bg-blue-900 transition duration-300"
                    >
                        <i class="fab fa-linkedin-in"></i>
                        <span>LinkedIn</span>
                    </button>
                    <button 
                        onclick="copyToClipboard()" 
                        class="flex items-center space-x-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-300"
                    >
                        <i class="fas fa-link"></i>
                        <span>Copy Link</span>
                    </button>
                    <button 
                        onclick="likePost()" 
                        class="flex items-center space-x-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300"
                        id="likeButton"
                    >
                        <i class="fas fa-heart"></i>
                        <span id="likesCount">{{ $post->likes_count }}</span>
                    </button>
                </div>
            </div>

            <!-- Author Bio -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <div class="flex items-start space-x-4">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900">{{ $post->author->name }}</h4>
                        <p class="text-gray-600 text-sm mb-2">Content Author at BN Car Transport</p>
                        <p class="text-gray-700">
                            Expert in vehicle transportation with years of experience in the logistics industry. 
                            Passionate about sharing insights and helpful tips for safe and efficient vehicle transport.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            @if($previousPost || $nextPost)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    @if($previousPost)
                        <div class="bg-white border rounded-lg p-6 hover:shadow-lg transition duration-300">
                            <div class="text-sm text-gray-500 mb-2">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Previous Article
                            </div>
                            <h4 class="font-semibold text-gray-900 hover:text-blue-600 transition duration-300">
                                <a href="{{ route('blog.show', $previousPost->slug) }}">{{ $previousPost->title }}</a>
                            </h4>
                        </div>
                    @endif

                    @if($nextPost)
                        <div class="bg-white border rounded-lg p-6 hover:shadow-lg transition duration-300 {{ !$previousPost ? 'md:col-start-2' : '' }}">
                            <div class="text-sm text-gray-500 mb-2">
                                Next Article
                                <i class="fas fa-arrow-right ml-1"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 hover:text-blue-600 transition duration-300">
                                <a href="{{ route('blog.show', $nextPost->slug) }}">{{ $nextPost->title }}</a>
                            </h4>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Related Posts -->
            @if($relatedPosts->count() > 0)
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Related Articles</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($relatedPosts as $relatedPost)
                            <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                                @if($relatedPost->featured_image_url)
                                    <img 
                                        src="{{ $relatedPost->featured_image_url }}" 
                                        alt="{{ $relatedPost->title }}"
                                        class="w-full h-48 object-cover"
                                    >
                                @endif
                                
                                <div class="p-4">
                                    @if($relatedPost->category)
                                        <div class="mb-2">
                                            <span 
                                                class="inline-block px-2 py-1 text-xs font-semibold rounded"
                                                style="background-color: {{ $relatedPost->category->color }}20; color: {{ $relatedPost->category->color }}"
                                            >
                                                {{ $relatedPost->category->name }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <h4 class="font-semibold text-gray-900 mb-2 hover:text-blue-600 transition duration-300 line-clamp-2">
                                        <a href="{{ route('blog.show', $relatedPost->slug) }}">{{ $relatedPost->title }}</a>
                                    </h4>
                                    
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $relatedPost->excerpt }}</p>
                                    
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span>{{ $relatedPost->published_ago }}</span>
                                        <span>{{ $relatedPost->reading_time }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        </article>

        <!-- Sidebar -->
        <aside class="lg:w-1/3">
            <div class="space-y-8 sticky top-8">
                <!-- Table of Contents -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Table of Contents</h3>
                    <div id="tableOfContents" class="space-y-2 text-sm">
                        <!-- Generated by JavaScript -->
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a 
                            href="{{ route('quote') }}" 
                            class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-lg font-semibold transition duration-300"
                        >
                            <i class="fas fa-calculator mr-2"></i>
                            Get Transport Quote
                        </a>
                        <a 
                            href="{{ route('contact') }}" 
                            class="block w-full bg-gray-600 hover:bg-gray-700 text-white text-center py-3 rounded-lg font-semibold transition duration-300"
                        >
                            <i class="fas fa-phone mr-2"></i>
                            Contact Us
                        </a>
                        <a 
                            href="{{ route('services') }}" 
                            class="block w-full border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white text-center py-3 rounded-lg font-semibold transition duration-300"
                        >
                            <i class="fas fa-truck mr-2"></i>
                            Our Services
                        </a>
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Categories</h3>
                    <ul class="space-y-2">
                        @foreach($categories as $category)
                            <li>
                                <a 
                                    href="{{ route('blog.category', $category->slug) }}" 
                                    class="flex items-center justify-between p-2 rounded hover:bg-gray-50 transition duration-300 {{ $post->category && $post->category->id === $category->id ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}"
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

                <!-- Newsletter Signup -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2">Stay Updated</h3>
                    <p class="text-blue-100 text-sm mb-4">Get the latest transport tips and industry news.</p>
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
        </aside>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain">
        <button 
            onclick="closeImageModal()" 
            class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full w-10 h-10 flex items-center justify-center hover:bg-opacity-75 transition duration-300"
        >
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endsection

@push('styles')
<style>
    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
        color: #1f2937;
        font-weight: 600;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    
    .prose h2 {
        font-size: 1.875rem;
        line-height: 2.25rem;
    }
    
    .prose h3 {
        font-size: 1.5rem;
        line-height: 2rem;
    }
    
    .prose p {
        margin-bottom: 1.5rem;
    }
    
    .prose ul, .prose ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    
    .prose li {
        margin-bottom: 0.5rem;
    }
    
    .prose blockquote {
        border-left: 4px solid #3b82f6;
        padding-left: 1rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #6b7280;
    }
    
    .prose img {
        border-radius: 0.5rem;
        margin: 1.5rem 0;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
// Table of Contents Generator
document.addEventListener('DOMContentLoaded', function() {
    generateTableOfContents();
});

function generateTableOfContents() {
    const headings = document.querySelectorAll('.prose h2, .prose h3');
    const tocContainer = document.getElementById('tableOfContents');
    
    if (headings.length === 0) {
        tocContainer.innerHTML = '<p class="text-gray-500 text-sm">No headings found</p>';
        return;
    }
    
    let tocHTML = '';
    headings.forEach((heading, index) => {
        const id = 'heading-' + index;
        heading.id = id;
        
        const level = heading.tagName === 'H2' ? '' : 'ml-4';
        tocHTML += `
            <a href="#${id}" class="block ${level} text-gray-700 hover:text-blue-600 py-1 transition duration-300">
                ${heading.textContent}
            </a>
        `;
    });
    
    tocContainer.innerHTML = tocHTML;
}

// Social Sharing Functions
function shareOnFacebook() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
    incrementShares();
}

function shareOnTwitter() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('{{ $post->title }} - {{ $post->excerpt ? Str::limit($post->excerpt, 100) : "" }}');
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
    incrementShares();
}

function shareOnLinkedIn() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank', 'width=600,height=400');
    incrementShares();
}

function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        // Show success message
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i> <span>Copied!</span>';
        
        setTimeout(() => {
            button.innerHTML = originalText;
        }, 2000);
        
        incrementShares();
    });
}

// Like Post Function
function likePost() {
    fetch(`/blog/like/{{ $post->id }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('likesCount').textContent = data.likes_count;
            
            // Animation effect
            const button = document.getElementById('likeButton');
            button.classList.add('animate-pulse');
            setTimeout(() => {
                button.classList.remove('animate-pulse');
            }, 500);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Increment Shares Function
function incrementShares() {
    fetch(`/blog/share/{{ $post->id }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Image Modal Functions
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside the image
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

// Smooth scrolling for TOC links
document.addEventListener('click', function(e) {
    if (e.target.matches('#tableOfContents a')) {
        e.preventDefault();
        const targetId = e.target.getAttribute('href').substring(1);
        const targetElement = document.getElementById(targetId);
        if (targetElement) {
            targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
});

// Reading Progress Indicator
window.addEventListener('scroll', function() {
    const article = document.querySelector('article');
    const articleTop = article.offsetTop;
    const articleHeight = article.offsetHeight;
    const windowHeight = window.innerHeight;
    const scrollTop = window.pageYOffset;
    
    const articleStart = articleTop - windowHeight / 2;
    const articleEnd = articleTop + articleHeight - windowHeight / 2;
    
    if (scrollTop >= articleStart && scrollTop <= articleEnd) {
        const progress = (scrollTop - articleStart) / (articleEnd - articleStart);
        // You can use this progress value to update a progress bar if needed
    }
});
</script>
@endpush