<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\QuoteRequestController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Public Website Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/services/{slug}', [HomeController::class, 'serviceDetail'])->name('service.detail');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');

// Quote Request Routes
Route::get('/quote', [QuoteController::class, 'index'])->name('quote');
Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');
Route::get('/quote/success', [QuoteController::class, 'success'])->name('quote.success');

// Dynamic Pages
Route::get('/page/{slug}', [HomeController::class, 'page'])->name('page');

/*
|--------------------------------------------------------------------------
| User Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
    // Admin Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Services Management
    Route::resource('services', ServiceController::class);
    Route::patch('services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('services.toggle-status');
    
    // Testimonials Management
    Route::resource('testimonials', TestimonialController::class);
    Route::patch('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::patch('testimonials/{testimonial}/toggle-featured', [TestimonialController::class, 'toggleFeatured'])->name('testimonials.toggle-featured');
    
    // Gallery Management
    Route::resource('galleries', GalleryController::class);
    Route::patch('galleries/{gallery}/toggle-status', [GalleryController::class, 'toggleStatus'])->name('galleries.toggle-status');
    Route::patch('galleries/{gallery}/toggle-featured', [GalleryController::class, 'toggleFeatured'])->name('galleries.toggle-featured');
    Route::delete('galleries/bulk-delete', [GalleryController::class, 'bulkDelete'])->name('galleries.bulk-delete');
    
    // Quote Requests Management
    Route::resource('quote-requests', QuoteRequestController::class)->except(['create', 'store']);
    Route::patch('quote-requests/{quoteRequest}/update-status', [QuoteRequestController::class, 'updateStatus'])->name('quote-requests.update-status');
    Route::post('quote-requests/{quoteRequest}/send-quote', [QuoteRequestController::class, 'sendQuote'])->name('quote-requests.send-quote');
    Route::post('quote-requests/{quoteRequest}/assign', [QuoteRequestController::class, 'assign'])->name('quote-requests.assign');
    Route::get('quote-requests-stats', [QuoteRequestController::class, 'stats'])->name('quote-requests.stats');
    
    // Pages Management
    Route::resource('pages', PageController::class);
    Route::patch('pages/{page}/toggle-status', [PageController::class, 'toggleStatus'])->name('pages.toggle-status');
    
    // Settings Management
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
