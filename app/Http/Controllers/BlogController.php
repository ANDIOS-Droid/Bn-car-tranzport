<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    /**
     * Display blog listing page
     */
    public function index(Request $request)
    {
        $query = BlogPost::published()
            ->with(['author', 'category'])
            ->latest('published_at');

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by tag
        if ($request->filled('tag')) {
            $query->byTag($request->tag);
        }

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Get posts with pagination
        $posts = $query->paginate(12);

        // Get featured posts for sidebar/hero
        $featuredPosts = BlogPost::published()
            ->featured()
            ->with(['author', 'category'])
            ->latest('published_at')
            ->limit(3)
            ->get();

        // Get popular posts for sidebar
        $popularPosts = BlogPost::published()
            ->popular(5)
            ->with(['author', 'category'])
            ->get();

        // Get recent posts for sidebar
        $recentPosts = BlogPost::published()
            ->recent(5)
            ->with(['author', 'category'])
            ->get();

        // Get categories for navigation
        $categories = BlogCategory::active()
            ->ordered()
            ->withCount(['publishedBlogPosts'])
            ->having('published_blog_posts_count', '>', 0)
            ->get();

        // Get all tags for tag cloud
        $allTags = BlogPost::getAllTags();

        // Get current filters for breadcrumbs
        $currentCategory = null;
        if ($request->filled('category')) {
            $currentCategory = BlogCategory::where('slug', $request->category)->first();
        }

        return view('blog.index', compact(
            'posts', 
            'featuredPosts', 
            'popularPosts', 
            'recentPosts', 
            'categories', 
            'allTags',
            'currentCategory'
        ));
    }

    /**
     * Display individual blog post
     */
    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->published()
            ->with(['author', 'category'])
            ->firstOrFail();

        // Increment views count
        $post->incrementViews();

        // Get related posts
        $relatedPosts = $post->getRelatedPosts(3);

        // Get next and previous posts
        $nextPost = $post->getNextPost();
        $previousPost = $post->getPreviousPost();

        // Get recent posts for sidebar
        $recentPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->recent(5)
            ->with(['author', 'category'])
            ->get();

        // Get categories for sidebar
        $categories = BlogCategory::active()
            ->ordered()
            ->withCount(['publishedBlogPosts'])
            ->having('published_blog_posts_count', '>', 0)
            ->get();

        // Get all tags for tag cloud
        $allTags = BlogPost::getAllTags();

        return view('blog.show', compact(
            'post', 
            'relatedPosts', 
            'nextPost', 
            'previousPost',
            'recentPosts', 
            'categories', 
            'allTags'
        ));
    }

    /**
     * Display posts by category
     */
    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $posts = BlogPost::published()
            ->where('blog_category_id', $category->id)
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(12);

        // Get other categories for navigation
        $categories = BlogCategory::active()
            ->ordered()
            ->withCount(['publishedBlogPosts'])
            ->having('published_blog_posts_count', '>', 0)
            ->get();

        // Get recent posts for sidebar
        $recentPosts = BlogPost::published()
            ->recent(5)
            ->with(['author', 'category'])
            ->get();

        // Get all tags for tag cloud
        $allTags = BlogPost::getAllTags();

        return view('blog.category', compact(
            'category', 
            'posts', 
            'categories', 
            'recentPosts', 
            'allTags'
        ));
    }

    /**
     * Display posts by tag
     */
    public function tag($tag)
    {
        $posts = BlogPost::published()
            ->byTag($tag)
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(12);

        // Get categories for navigation
        $categories = BlogCategory::active()
            ->ordered()
            ->withCount(['publishedBlogPosts'])
            ->having('published_blog_posts_count', '>', 0)
            ->get();

        // Get recent posts for sidebar
        $recentPosts = BlogPost::published()
            ->recent(5)
            ->with(['author', 'category'])
            ->get();

        // Get all tags for tag cloud
        $allTags = BlogPost::getAllTags();

        return view('blog.tag', compact(
            'tag', 
            'posts', 
            'categories', 
            'recentPosts', 
            'allTags'
        ));
    }

    /**
     * Search blog posts
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100'
        ]);

        $searchTerm = $request->input('q');

        $posts = BlogPost::published()
            ->search($searchTerm)
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(12)
            ->appends(['q' => $searchTerm]);

        // Get categories for navigation
        $categories = BlogCategory::active()
            ->ordered()
            ->withCount(['publishedBlogPosts'])
            ->having('published_blog_posts_count', '>', 0)
            ->get();

        // Get recent posts for sidebar
        $recentPosts = BlogPost::published()
            ->recent(5)
            ->with(['author', 'category'])
            ->get();

        // Get all tags for tag cloud
        $allTags = BlogPost::getAllTags();

        return view('blog.search', compact(
            'searchTerm', 
            'posts', 
            'categories', 
            'recentPosts', 
            'allTags'
        ));
    }

    /**
     * Get blog data for AJAX requests
     */
    public function getData(Request $request)
    {
        $type = $request->input('type', 'recent');
        $limit = $request->input('limit', 5);

        switch ($type) {
            case 'featured':
                $posts = BlogPost::published()
                    ->featured()
                    ->with(['author', 'category'])
                    ->latest('published_at')
                    ->limit($limit)
                    ->get();
                break;

            case 'popular':
                $posts = BlogPost::published()
                    ->popular($limit)
                    ->with(['author', 'category'])
                    ->get();
                break;

            case 'recent':
            default:
                $posts = BlogPost::published()
                    ->recent($limit)
                    ->with(['author', 'category'])
                    ->get();
                break;
        }

        return response()->json([
            'posts' => $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'excerpt' => $post->excerpt,
                    'featured_image_url' => $post->featured_image_url,
                    'published_at' => $post->formatted_published_date,
                    'published_ago' => $post->published_ago,
                    'reading_time' => $post->reading_time,
                    'views_count' => $post->views_count,
                    'author' => [
                        'name' => $post->author->name,
                    ],
                    'category' => $post->category ? [
                        'name' => $post->category->name,
                        'slug' => $post->category->slug,
                        'color' => $post->category->color,
                    ] : null,
                    'url' => route('blog.show', $post->slug),
                ];
            })
        ]);
    }

    /**
     * Like a blog post (AJAX)
     */
    public function like(BlogPost $blogPost)
    {
        $blogPost->incrementLikes();

        return response()->json([
            'success' => true,
            'likes_count' => $blogPost->fresh()->likes_count
        ]);
    }

    /**
     * Share a blog post (AJAX)
     */
    public function share(BlogPost $blogPost)
    {
        $blogPost->incrementShares();

        return response()->json([
            'success' => true,
            'shares_count' => $blogPost->fresh()->shares_count
        ]);
    }

    /**
     * Get blog RSS feed
     */
    public function rss()
    {
        $posts = BlogPost::published()
            ->with(['author', 'category'])
            ->latest('published_at')
            ->limit(20)
            ->get();

        $xml = view('blog.rss', compact('posts'));

        return response($xml)->header('Content-Type', 'application/xml');
    }

    /**
     * Get blog sitemap
     */
    public function sitemap()
    {
        $posts = BlogPost::published()
            ->latest('published_at')
            ->get();

        $categories = BlogCategory::active()
            ->ordered()
            ->get();

        $xml = view('blog.sitemap', compact('posts', 'categories'));

        return response($xml)->header('Content-Type', 'application/xml');
    }
}