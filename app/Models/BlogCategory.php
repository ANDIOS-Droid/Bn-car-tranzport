<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'image',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
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
     * Relationship: Blog posts in this category
     */
    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }

    /**
     * Relationship: Published blog posts in this category
     */
    public function publishedBlogPosts()
    {
        return $this->hasMany(BlogPost::class)->where('status', 'published')->where('published_at', '<=', now());
    }

    /**
     * Scope: Only active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Ordered by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get the category image URL
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    /**
     * Get published posts count
     */
    public function getPublishedPostsCountAttribute()
    {
        return $this->publishedBlogPosts()->count();
    }

    /**
     * Get category color with default
     */
    public function getColorAttribute($value)
    {
        return $value ?: '#3B82F6';
    }

    /**
     * Get the meta title or fallback to name
     */
    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->name;
    }

    /**
     * Get the meta description or fallback to description
     */
    public function getMetaDescriptionAttribute($value)
    {
        return $value ?: Str::limit($this->description, 155);
    }

    /**
     * Check if category has any published posts
     */
    public function hasPublishedPosts()
    {
        return $this->publishedBlogPosts()->exists();
    }

    /**
     * Get latest published posts from this category
     */
    public function latestPosts($limit = 5)
    {
        return $this->publishedBlogPosts()
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Generate unique slug
     */
    public function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id ?? 0)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}