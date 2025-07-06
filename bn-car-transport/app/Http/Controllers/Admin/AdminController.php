<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Gallery;
use App\Models\QuoteRequest;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with overview statistics
     */
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_services' => Service::count(),
            'active_services' => Service::where('is_active', true)->count(),
            'total_testimonials' => Testimonial::count(),
            'approved_testimonials' => Testimonial::where('is_approved', true)->count(),
            'total_gallery_images' => Gallery::count(),
            'total_quote_requests' => QuoteRequest::count(),
            'pending_quotes' => QuoteRequest::where('status', 'pending')->count(),
            'total_pages' => Page::count(),
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
        ];

        // Get recent quote requests
        $recent_quotes = QuoteRequest::with('assignedTo')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get recent testimonials
        $recent_testimonials = Testimonial::where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Quote status breakdown
        $quote_status_breakdown = QuoteRequest::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.dashboard', compact(
            'stats',
            'recent_quotes',
            'recent_testimonials',
            'quote_status_breakdown'
        ));
    }
}
