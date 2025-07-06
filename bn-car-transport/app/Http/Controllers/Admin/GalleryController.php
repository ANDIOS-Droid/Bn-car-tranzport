<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(12);
        
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'category' => 'required|in:transport,vehicles,team,office,general',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'alt_text' => 'nullable|string|max:255',
        ]);

        // Handle image upload and create thumbnail
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('gallery', 'public');
            
            // Create thumbnail (if Intervention Image is available)
            try {
                $thumbnailPath = 'gallery/thumbnails/' . basename($imagePath);
                $thumbnailFullPath = storage_path('app/public/' . $thumbnailPath);
                
                // Create thumbnails directory if it doesn't exist
                if (!file_exists(dirname($thumbnailFullPath))) {
                    mkdir(dirname($thumbnailFullPath), 0755, true);
                }
                
                // Create thumbnail (300x200)
                $img = Image::make(storage_path('app/public/' . $imagePath));
                $img->fit(300, 200)->save($thumbnailFullPath);
                
                $validated['thumbnail'] = $thumbnailPath;
            } catch (\Exception $e) {
                // If image processing fails, continue without thumbnail
                $validated['thumbnail'] = null;
            }
            
            $validated['image'] = $imagePath;
        }

        Gallery::create($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery image uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return view('admin.galleries.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category' => 'required|in:transport,vehicles,team,office,general',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'alt_text' => 'nullable|string|max:255',
        ]);

        // Handle image upload if new image is provided
        if ($request->hasFile('image')) {
            // Delete old images
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }
            if ($gallery->thumbnail && Storage::disk('public')->exists($gallery->thumbnail)) {
                Storage::disk('public')->delete($gallery->thumbnail);
            }

            $image = $request->file('image');
            $imagePath = $image->store('gallery', 'public');
            
            // Create thumbnail
            try {
                $thumbnailPath = 'gallery/thumbnails/' . basename($imagePath);
                $thumbnailFullPath = storage_path('app/public/' . $thumbnailPath);
                
                if (!file_exists(dirname($thumbnailFullPath))) {
                    mkdir(dirname($thumbnailFullPath), 0755, true);
                }
                
                $img = Image::make(storage_path('app/public/' . $imagePath));
                $img->fit(300, 200)->save($thumbnailFullPath);
                
                $validated['thumbnail'] = $thumbnailPath;
            } catch (\Exception $e) {
                $validated['thumbnail'] = null;
            }
            
            $validated['image'] = $imagePath;
        }

        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery image updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        // Delete associated images
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }
        if ($gallery->thumbnail && Storage::disk('public')->exists($gallery->thumbnail)) {
            Storage::disk('public')->delete($gallery->thumbnail);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery image deleted successfully.');
    }

    /**
     * Toggle gallery item status (active/inactive)
     */
    public function toggleStatus(Gallery $gallery)
    {
        $gallery->update(['is_active' => !$gallery->is_active]);

        $status = $gallery->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Gallery image has been {$status} successfully.");
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Gallery $gallery)
    {
        $gallery->update(['is_featured' => !$gallery->is_featured]);

        $status = $gallery->is_featured ? 'featured' : 'unfeatured';
        
        return redirect()->back()
            ->with('success', "Gallery image has been {$status} successfully.");
    }

    /**
     * Bulk delete gallery items
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'selected' => 'required|array',
            'selected.*' => 'exists:galleries,id',
        ]);

        $galleries = Gallery::whereIn('id', $validated['selected'])->get();

        foreach ($galleries as $gallery) {
            // Delete images
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }
            if ($gallery->thumbnail && Storage::disk('public')->exists($gallery->thumbnail)) {
                Storage::disk('public')->delete($gallery->thumbnail);
            }
            
            $gallery->delete();
        }

        return redirect()->route('admin.galleries.index')
            ->with('success', count($galleries) . ' gallery images deleted successfully.');
    }
}
