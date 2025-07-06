<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'location',
        'message',
        'rating',
        'service_used',
        'image',
        'is_approved',
        'is_featured',
        'service_date',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'service_date' => 'date',
        'rating' => 'integer',
    ];

    /**
     * Scope for approved testimonials
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope for featured testimonials
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for latest testimonials
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Get star rating as HTML
     */
    public function getStarRatingAttribute()
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $html .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $html .= '<i class="far fa-star text-muted"></i>';
            }
        }
        return $html;
    }

    /**
     * Get formatted service date
     */
    public function getFormattedServiceDateAttribute()
    {
        return $this->service_date ? $this->service_date->format('F Y') : '';
    }
}
