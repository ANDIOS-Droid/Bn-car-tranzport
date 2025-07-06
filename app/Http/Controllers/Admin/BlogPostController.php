<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BlogPost::with(['author', 'category'])->latest('created_at');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->category);
        }

        // Filter by author
        if ($request->filled('author')) {
            $query->where('user_id', $request->author);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === '1');
        }

        $posts = $query->paginate(15);

        // Get filter options
        $categories = BlogCategory::active()->ordered()->get();
        $authors = User::where('role', 'admin')->get();

        // Get statistics
        $stats = [
            'total' => BlogPost::count(),
            'published' => BlogPost::where('status', 'published')->count(),
            'draft' => BlogPost::where('status', 'draft')->count(),
            'scheduled' => BlogPost::where('status', 'scheduled')->count(),
            'featured' => BlogPost::where('is_featured', true)->count(),
        ];

        return view('admin.blog-posts.index', compact('posts', 'categories', 'authors', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::active()->ordered()->get();
        $authors = User::where('role', 'admin')->get();
        
        return view('admin.blog-posts.create', compact('categories', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'status' => 'required|in:draft,published,scheduled,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'allow_comments' => 'boolean',
            'tags' => 'nullable|string',
            'reading_time' => 'nullable|string|max:50',
            // SEO fields
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
            'meta_keywords' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|url',
            // Social media
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:300',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Set author
        $validated['user_id'] = auth()->id();

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (BlogPost::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle published_at
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        } elseif ($validated['status'] === 'scheduled' && empty($validated['published_at'])) {
            return back()->withErrors(['published_at' => 'Published date is required for scheduled posts.'])->withInput();
        }

        // Process tags
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog/featured', 'public');
        }

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $request->file('og_image')->store('blog/og-images', 'public');
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('blog/gallery', 'public');
            }
            $validated['gallery'] = $galleryPaths;
        }

        $post = BlogPost::create($validated);

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blogPost)
    {
        $blogPost->load(['author', 'category']);
        
        return view('admin.blog-posts.show', compact('blogPost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blogPost)
    {
        $categories = BlogCategory::active()->ordered()->get();
        $authors = User::where('role', 'admin')->get();
        
        return view('admin.blog-posts.edit', compact('blogPost', 'categories', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug,' . $blogPost->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'status' => 'required|in:draft,published,scheduled,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'allow_comments' => 'boolean',
            'tags' => 'nullable|string',
            'reading_time' => 'nullable|string|max:50',
            // SEO fields
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
            'meta_keywords' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|url',
            // Social media
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:300',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_featured_image' => 'boolean',
            'remove_og_image' => 'boolean',
            'remove_gallery' => 'nullable|array',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (BlogPost::where('slug', $validated['slug'])->where('id', '!=', $blogPost->id)->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle published_at
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        } elseif ($validated['status'] === 'scheduled' && empty($validated['published_at'])) {
            return back()->withErrors(['published_at' => 'Published date is required for scheduled posts.'])->withInput();
        }

        // Process tags
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        } else {
            $validated['tags'] = null;
        }

        // Handle featured image removal
        if ($request->filled('remove_featured_image') && $blogPost->featured_image) {
            Storage::disk('public')->delete($blogPost->featured_image);
            $validated['featured_image'] = null;
        }

        // Handle new featured image upload
        if ($request->hasFile('featured_image')) {
            if ($blogPost->featured_image) {
                Storage::disk('public')->delete($blogPost->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blog/featured', 'public');
        }

        // Handle OG image removal
        if ($request->filled('remove_og_image') && $blogPost->og_image) {
            Storage::disk('public')->delete($blogPost->og_image);
            $validated['og_image'] = null;
        }

        // Handle new OG image upload
        if ($request->hasFile('og_image')) {
            if ($blogPost->og_image) {
                Storage::disk('public')->delete($blogPost->og_image);
            }
            $validated['og_image'] = $request->file('og_image')->store('blog/og-images', 'public');
        }

        // Handle gallery removal
        if ($request->filled('remove_gallery')) {
            $currentGallery = $blogPost->gallery ?: [];
            $toRemove = $request->input('remove_gallery', []);
            
            foreach ($toRemove as $imagePath) {
                if (in_array($imagePath, $currentGallery)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
            
            $validated['gallery'] = array_values(array_diff($currentGallery, $toRemove));
        }

        // Handle new gallery images
        if ($request->hasFile('gallery')) {
            $currentGallery = $validated['gallery'] ?? $blogPost->gallery ?? [];
            foreach ($request->file('gallery') as $image) {
                $currentGallery[] = $image->store('blog/gallery', 'public');
            }
            $validated['gallery'] = $currentGallery;
        }

        $blogPost->update($validated);

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blogPost)
    {
        // Delete associated images
        if ($blogPost->featured_image) {
            Storage::disk('public')->delete($blogPost->featured_image);
        }
        
        if ($blogPost->og_image) {
            Storage::disk('public')->delete($blogPost->og_image);
        }
        
        if ($blogPost->gallery) {
            foreach ($blogPost->gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $blogPost->delete();

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post deleted successfully.');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(BlogPost $blogPost)
    {
        $blogPost->update(['is_featured' => !$blogPost->is_featured]);

        $status = $blogPost->is_featured ? 'featured' : 'unfeatured';
        
        return redirect()->back()
            ->with('success', "Blog post has been {$status} successfully.");
    }

    /**
     * Toggle post status
     */
    public function toggleStatus(BlogPost $blogPost)
    {
        $newStatus = $blogPost->status === 'published' ? 'draft' : 'published';
        
        $updateData = ['status' => $newStatus];
        
        if ($newStatus === 'published' && !$blogPost->published_at) {
            $updateData['published_at'] = now();
        }
        
        $blogPost->update($updateData);

        return redirect()->back()
            ->with('success', "Blog post status changed to {$newStatus} successfully.");
    }

    /**
     * Duplicate a blog post
     */
    public function duplicate(BlogPost $blogPost)
    {
        $newPost = $blogPost->replicate();
        $newPost->title = $blogPost->title . ' (Copy)';
        $newPost->slug = $blogPost->generateUniqueSlug($newPost->title);
        $newPost->status = 'draft';
        $newPost->published_at = null;
        $newPost->views_count = 0;
        $newPost->likes_count = 0;
        $newPost->shares_count = 0;
        $newPost->user_id = auth()->id();
        $newPost->save();

        return redirect()->route('admin.blog-posts.edit', $newPost)
            ->with('success', 'Blog post duplicated successfully.');
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete,publish,unpublish,feature,unfeature',
            'selected' => 'required|array',
            'selected.*' => 'exists:blog_posts,id',
        ]);

        $posts = BlogPost::whereIn('id', $validated['selected']);

        switch ($validated['action']) {
            case 'delete':
                foreach ($posts->get() as $post) {
                    // Delete associated images
                    if ($post->featured_image) {
                        Storage::disk('public')->delete($post->featured_image);
                    }
                    if ($post->og_image) {
                        Storage::disk('public')->delete($post->og_image);
                    }
                    if ($post->gallery) {
                        foreach ($post->gallery as $image) {
                            Storage::disk('public')->delete($image);
                        }
                    }
                    $post->delete();
                }
                $message = count($validated['selected']) . ' posts deleted successfully.';
                break;

            case 'publish':
                $posts->update(['status' => 'published', 'published_at' => now()]);
                $message = count($validated['selected']) . ' posts published successfully.';
                break;

            case 'unpublish':
                $posts->update(['status' => 'draft']);
                $message = count($validated['selected']) . ' posts unpublished successfully.';
                break;

            case 'feature':
                $posts->update(['is_featured' => true]);
                $message = count($validated['selected']) . ' posts featured successfully.';
                break;

            case 'unfeature':
                $posts->update(['is_featured' => false]);
                $message = count($validated['selected']) . ' posts unfeatured successfully.';
                break;
        }

        return redirect()->route('admin.blog-posts.index')
            ->with('success', $message);
    }
}