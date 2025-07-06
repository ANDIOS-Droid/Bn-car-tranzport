<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'is_published',
        'show_in_menu',
        'menu_order',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'template',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'show_in_menu' => 'boolean',
        'meta_keywords' => 'array',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    /**
     * Scope for published pages
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for menu pages
     */
    public function scopeInMenu($query)
    {
        return $query->where('show_in_menu', true)->orderBy('menu_order');
    }

    /**
     * Get the route key for the model
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
