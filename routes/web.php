<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\QuoteRequestController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/services/{service}', [HomeController::class, 'serviceDetail'])->name('service.detail');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');

// Quote Request Routes
Route::get('/quote', [HomeController::class, 'quote'])->name('quote');
Route::post('/quote', [HomeController::class, 'quoteSubmit'])->name('quote.submit');
Route::get('/quote/success', [HomeController::class, 'quoteSuccess'])->name('quote.success');

// Blog Routes
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/search', [BlogController::class, 'search'])->name('search');
    Route::get('/category/{slug}', [BlogController::class, 'category'])->name('category');
    Route::get('/tag/{tag}', [BlogController::class, 'tag'])->name('tag');
    Route::get('/data', [BlogController::class, 'getData'])->name('data');
    Route::post('/like/{blogPost}', [BlogController::class, 'like'])->name('like');
    Route::post('/share/{blogPost}', [BlogController::class, 'share'])->name('share');
    Route::get('/rss', [BlogController::class, 'rss'])->name('rss');
    Route::get('/sitemap', [BlogController::class, 'sitemap'])->name('sitemap');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Services
    Route::resource('services', ServiceController::class);
    Route::patch('services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('services.toggle-status');
    
    // Testimonials
    Route::resource('testimonials', TestimonialController::class);
    Route::patch('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::patch('testimonials/{testimonial}/toggle-featured', [TestimonialController::class, 'toggleFeatured'])->name('testimonials.toggle-featured');
    
    // Gallery
    Route::resource('galleries', GalleryController::class);
    Route::patch('galleries/{gallery}/toggle-status', [GalleryController::class, 'toggleStatus'])->name('galleries.toggle-status');
    Route::patch('galleries/{gallery}/toggle-featured', [GalleryController::class, 'toggleFeatured'])->name('galleries.toggle-featured');
    Route::delete('galleries/bulk-delete', [GalleryController::class, 'bulkDelete'])->name('galleries.bulk-delete');
    
    // Quote Requests
    Route::resource('quote-requests', QuoteRequestController::class)->except(['create', 'store']);
    Route::patch('quote-requests/{quoteRequest}/update-status', [QuoteRequestController::class, 'updateStatus'])->name('quote-requests.update-status');
    Route::post('quote-requests/{quoteRequest}/send-quote', [QuoteRequestController::class, 'sendQuote'])->name('quote-requests.send-quote');
    Route::post('quote-requests/{quoteRequest}/assign', [QuoteRequestController::class, 'assign'])->name('quote-requests.assign');
    Route::get('quote-requests-stats', [QuoteRequestController::class, 'stats'])->name('quote-requests.stats');
    
    // Blog Categories
    Route::resource('blog-categories', BlogCategoryController::class);
    Route::patch('blog-categories/{blogCategory}/toggle-status', [BlogCategoryController::class, 'toggleStatus'])->name('blog-categories.toggle-status');
    
    // Blog Posts
    Route::resource('blog-posts', BlogPostController::class);
    Route::patch('blog-posts/{blogPost}/toggle-featured', [BlogPostController::class, 'toggleFeatured'])->name('blog-posts.toggle-featured');
    Route::patch('blog-posts/{blogPost}/toggle-status', [BlogPostController::class, 'toggleStatus'])->name('blog-posts.toggle-status');
    Route::post('blog-posts/{blogPost}/duplicate', [BlogPostController::class, 'duplicate'])->name('blog-posts.duplicate');
    Route::post('blog-posts/bulk-action', [BlogPostController::class, 'bulkAction'])->name('blog-posts.bulk-action');
    
    // Pages
    Route::resource('pages', PageController::class);
    Route::patch('pages/{page}/toggle-status', [PageController::class, 'toggleStatus'])->name('pages.toggle-status');
    
    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('settings/{group}', [SettingController::class, 'group'])->name('settings.group');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('settings/store', [SettingController::class, 'store'])->name('settings.store');
    Route::delete('settings/{key}', [SettingController::class, 'destroy'])->name('settings.destroy');
    Route::get('settings/export', [SettingController::class, 'export'])->name('settings.export');
    Route::post('settings/import', [SettingController::class, 'import'])->name('settings.import');
    Route::post('settings/reset', [SettingController::class, 'reset'])->name('settings.reset');
});

require __DIR__.'/auth.php';