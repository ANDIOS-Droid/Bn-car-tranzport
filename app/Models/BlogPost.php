<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'gallery',
        'user_id',
        'blog_category_id',
        'status',
        'published_at',
        'is_featured',
        'allow_comments',
        'views_count',
        'likes_count',
        'shares_count',
        'tags',
        'reading_time',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'shares_count' => 'integer',
        'gallery' => 'array',
        'tags' => 'array',
    ];

    protected $dates = [
        'published_at',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            
            // Auto-generate excerpt if not provided
            if (empty($post->excerpt) && !empty($post->content)) {
                $post->excerpt = Str::limit(strip_tags($post->content), 200);
            }

            // Calculate reading time
            if (!empty($post->content) && empty($post->reading_time)) {
                $post->reading_time = $post->calculateReadingTime($post->content);
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }

            if ($post->isDirty('content')) {
                // Update excerpt if content changed and excerpt is empty
                if (empty($post->excerpt)) {
                    $post->excerpt = Str::limit(strip_tags($post->content), 200);
                }
                
                // Recalculate reading time
                if (empty($post->reading_time)) {
                    $post->reading_time = $post->calculateReadingTime($post->content);
                }
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Relationship: Author (User)
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: Category
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    /**
     * Scope: Only published posts
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope: Featured posts
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: By category
     */
    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    /**
     * Scope: Search posts
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('excerpt', 'like', "%{$term}%")
              ->orWhere('content', 'like', "%{$term}%")
              ->orWhereJsonContains('tags', $term);
        });
    }

    /**
     * Scope: By tag
     */
    public function scopeByTag($query, $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }

    /**
     * Scope: Recent posts
     */
    public function scopeRecent($query, $limit = 5)
    {
        return $query->latest('published_at')->limit($limit);
    }

    /**
     * Scope: Popular posts (by views)
     */
    public function scopePopular($query, $limit = 5)
    {
        return $query->orderBy('views_count', 'desc')->limit($limit);
    }

    /**
     * Get the featured image URL
     */
    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image ? Storage::url($this->featured_image) : null;
    }

    /**
     * Get the OG image URL
     */
    public function getOgImageUrlAttribute()
    {
        if ($this->og_image) {
            return Storage::url($this->og_image);
        }
        return $this->featured_image_url;
    }

    /**
     * Get gallery image URLs
     */
    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery) return [];
        
        return collect($this->gallery)->map(function($image) {
            return Storage::url($image);
        })->toArray();
    }

    /**
     * Check if post is published
     */
    public function isPublished()
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

    /**
     * Check if post is scheduled
     */
    public function isScheduled()
    {
        return $this->status === 'scheduled' || 
               ($this->status === 'published' && $this->published_at > now());
    }

    /**
     * Get formatted published date
     */
    public function getFormattedPublishedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('F j, Y') : null;
    }

    /**
     * Get human readable published date
     */
    public function getPublishedAgoAttribute()
    {
        return $this->published_at ? $this->published_at->diffForHumans() : null;
    }

    /**
     * Get estimated reading time
     */
    public function getReadingTimeAttribute($value)
    {
        if ($value) return $value;
        
        return $this->calculateReadingTime($this->content);
    }

    /**
     * Calculate reading time based on content
     */
    public function calculateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = ceil($wordCount / 200); // Average reading speed: 200 words per minute
        
        return $minutes . ' min read';
    }

    /**
     * Get meta title or fallback to title
     */
    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    /**
     * Get meta description or fallback to excerpt
     */
    public function getMetaDescriptionAttribute($value)
    {
        return $value ?: Str::limit($this->excerpt ?: strip_tags($this->content), 155);
    }

    /**
     * Get OG title or fallback to title
     */
    public function getOgTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    /**
     * Get OG description or fallback to excerpt
     */
    public function getOgDescriptionAttribute($value)
    {
        return $value ?: Str::limit($this->excerpt ?: strip_tags($this->content), 200);
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Increment likes count
     */
    public function incrementLikes()
    {
        $this->increment('likes_count');
    }

    /**
     * Increment shares count
     */
    public function incrementShares()
    {
        $this->increment('shares_count');
    }

    /**
     * Get related posts
     */
    public function getRelatedPosts($limit = 3)
    {
        return static::published()
            ->where('id', '!=', $this->id)
            ->where(function($query) {
                if ($this->blog_category_id) {
                    $query->where('blog_category_id', $this->blog_category_id);
                }
                
                // Also include posts with similar tags
                if ($this->tags) {
                    foreach ($this->tags as $tag) {
                        $query->orWhereJsonContains('tags', $tag);
                    }
                }
            })
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /**
     * Get next published post
     */
    public function getNextPost()
    {
        return static::published()
            ->where('published_at', '>', $this->published_at)
            ->orderBy('published_at', 'asc')
            ->first();
    }

    /**
     * Get previous published post
     */
    public function getPreviousPost()
    {
        return static::published()
            ->where('published_at', '<', $this->published_at)
            ->orderBy('published_at', 'desc')
            ->first();
    }

    /**
     * Get all unique tags from published posts
     */
    public static function getAllTags()
    {
        return static::published()
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->values()
            ->sort();
    }

    /**
     * Generate unique slug
     */
    public function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id ?? 0)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Auto-publish scheduled posts
     */
    public static function publishScheduledPosts()
    {
        return static::where('status', 'scheduled')
            ->where('published_at', '<=', now())
            ->update(['status' => 'published']);
    }
}