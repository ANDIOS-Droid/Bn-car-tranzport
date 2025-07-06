<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display all settings grouped by category
     */
    public function index()
    {
        $settings = Setting::orderBy('group')
            ->orderBy('sort_order')
            ->orderBy('label')
            ->get()
            ->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Display settings for a specific group
     */
    public function group($group)
    {
        $settings = Setting::where('group', $group)
            ->orderBy('sort_order')
            ->orderBy('label')
            ->get();

        return view('admin.settings.group', compact('settings', 'group'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $settings = $request->except(['_token', '_method']);
        
        foreach ($settings as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            if ($setting && $setting->is_editable) {
                // Handle file uploads for image type settings
                if ($setting->type === 'image' && $request->hasFile($key)) {
                    // Delete old image if exists
                    if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                        Storage::disk('public')->delete($setting->value);
                    }
                    
                    // Store new image
                    $imagePath = $request->file($key)->store('settings', 'public');
                    $value = $imagePath;
                }
                
                // Handle boolean values
                if ($setting->type === 'boolean') {
                    $value = $request->has($key) ? 'true' : 'false';
                }
                
                // Handle array/json values
                if ($setting->type === 'json' && is_array($value)) {
                    $value = json_encode($value);
                }
                
                $setting->update(['value' => $value]);
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = Setting::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }
        
        // Handle different types
        switch ($setting->type) {
            case 'boolean':
                return $setting->value === 'true';
            case 'json':
                return json_decode($setting->value, true) ?: $default;
            case 'image':
                return $setting->value ? Storage::url($setting->value) : $default;
            default:
                return $setting->value ?: $default;
        }
    }

    /**
     * Set setting value
     */
    public static function set($key, $value, $type = 'text')
    {
        $setting = Setting::where('key', $key)->first();
        
        if ($setting) {
            $setting->update(['value' => $value]);
        } else {
            Setting::create([
                'key' => $key,
                'value' => $value,
                'type' => $type,
                'group' => 'general',
                'label' => ucwords(str_replace('_', ' ', $key)),
                'is_editable' => true,
            ]);
        }
        
        return true;
    }

    /**
     * Create a new setting
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:settings,key',
            'value' => 'nullable|string',
            'type' => 'required|in:text,textarea,boolean,image,json,email,url,number',
            'group' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_editable' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        Setting::create($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting created successfully.');
    }

    /**
     * Delete a setting
     */
    public function destroy($key)
    {
        $setting = Setting::where('key', $key)->first();
        
        if (!$setting) {
            return redirect()->back()->with('error', 'Setting not found.');
        }
        
        if (!$setting->is_editable) {
            return redirect()->back()->with('error', 'This setting cannot be deleted.');
        }
        
        // Delete associated image if exists
        if ($setting->type === 'image' && $setting->value && Storage::disk('public')->exists($setting->value)) {
            Storage::disk('public')->delete($setting->value);
        }
        
        $setting->delete();
        
        return redirect()->back()->with('success', 'Setting deleted successfully.');
    }

    /**
     * Export settings as JSON
     */
    public function export()
    {
        $settings = Setting::all()->map(function ($setting) {
            return [
                'key' => $setting->key,
                'value' => $setting->value,
                'type' => $setting->type,
                'group' => $setting->group,
                'label' => $setting->label,
                'description' => $setting->description,
                'is_editable' => $setting->is_editable,
                'sort_order' => $setting->sort_order,
            ];
        });

        $filename = 'settings_' . now()->format('Y_m_d_H_i_s') . '.json';
        
        return response()->json($settings)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Import settings from JSON
     */
    public function import(Request $request)
    {
        $request->validate([
            'settings_file' => 'required|file|mimes:json',
        ]);

        $file = $request->file('settings_file');
        $content = file_get_contents($file->getRealPath());
        $settings = json_decode($content, true);

        if (!$settings) {
            return redirect()->back()->with('error', 'Invalid settings file.');
        }

        $imported = 0;
        foreach ($settings as $settingData) {
            if (isset($settingData['key'])) {
                Setting::updateOrCreate(
                    ['key' => $settingData['key']],
                    $settingData
                );
                $imported++;
            }
        }

        return redirect()->back()->with('success', "{$imported} settings imported successfully.");
    }

    /**
     * Reset settings to default
     */
    public function reset(Request $request)
    {
        $request->validate([
            'group' => 'nullable|string',
        ]);

        $query = Setting::where('is_editable', true);
        
        if ($request->filled('group')) {
            $query->where('group', $request->group);
        }
        
        $settings = $query->get();
        
        foreach ($settings as $setting) {
            // Delete image files if any
            if ($setting->type === 'image' && $setting->value && Storage::disk('public')->exists($setting->value)) {
                Storage::disk('public')->delete($setting->value);
            }
            
            $setting->update(['value' => '']);
        }

        $group = $request->group ? "for {$request->group} group" : '';
        
        return redirect()->back()->with('success', "Settings reset successfully {$group}.");
    }
}
