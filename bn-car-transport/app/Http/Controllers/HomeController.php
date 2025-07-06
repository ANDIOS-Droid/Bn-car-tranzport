<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        $services = Service::active()->orderBy('sort_order')->take(3)->get();
        $testimonials = Testimonial::approved()->featured()->take(3)->get();
        $galleryImages = Gallery::active()->featured()->take(6)->get();
        
        return view('home', compact('services', 'testimonials', 'galleryImages'));
    }

    /**
     * Display about page
     */
    public function about()
    {
        $page = Page::where('slug', 'about')->first();
        $testimonials = Testimonial::approved()->take(6)->get();
        
        return view('about', compact('page', 'testimonials'));
    }

    /**
     * Display services listing
     */
    public function services()
    {
        $services = Service::active()->orderBy('sort_order')->get();
        
        return view('services', compact('services'));
    }

    /**
     * Display single service detail
     */
    public function serviceDetail($slug)
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedServices = Service::active()
            ->where('id', '!=', $service->id)
            ->where('service_type', $service->service_type)
            ->take(3)
            ->get();
        
        return view('service-detail', compact('service', 'relatedServices'));
    }

    /**
     * Display gallery
     */
    public function gallery()
    {
        $images = Gallery::active()->orderBy('sort_order')->paginate(12);
        
        return view('gallery', compact('images'));
    }

    /**
     * Display testimonials
     */
    public function testimonials()
    {
        $testimonials = Testimonial::approved()->orderBy('created_at', 'desc')->paginate(10);
        
        return view('testimonials', compact('testimonials'));
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        $page = Page::where('slug', 'contact')->first();
        
        return view('contact', compact('page'));
    }

    /**
     * Handle contact form submission
     */
    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Here you would typically send an email
        // For now, just redirect with success message
        
        return redirect()->route('contact')
            ->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    /**
     * Display dynamic page
     */
    public function page($slug)
    {
        $page = Page::where('slug', $slug)->where('is_published', true)->firstOrFail();
        
        return view('page', compact('page'));
    }
}
