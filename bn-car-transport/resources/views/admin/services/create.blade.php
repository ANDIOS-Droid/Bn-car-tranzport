@extends('admin.layouts.app')

@section('title', 'Create Service')
@section('page-title', 'Create New Service')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Create New Service</h2>
                    <p class="text-sm text-gray-600">Add a new transportation service to your offerings</p>
                </div>
                <a href="{{ route('admin.services.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Services
                </a>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Basic Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Enter the basic details of your service.</p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2 space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Service Title *</label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title') }}"
                                   class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('title') border-red-300 @enderror"
                                   placeholder="e.g., Car Transportation">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Short Description *</label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="3"
                                      class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('description') border-red-300 @enderror"
                                      placeholder="Brief description of the service...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Service Type -->
                        <div>
                            <label for="service_type" class="block text-sm font-medium text-gray-700">Service Type *</label>
                            <select name="service_type" 
                                    id="service_type"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('service_type') border-red-300 @enderror">
                                <option value="">Select service type</option>
                                <option value="car_transport" {{ old('service_type') == 'car_transport' ? 'selected' : '' }}>Car Transport</option>
                                <option value="bike_transport" {{ old('service_type') == 'bike_transport' ? 'selected' : '' }}>Bike Transport</option>
                                <option value="both" {{ old('service_type') == 'both' ? 'selected' : '' }}>Both Car & Bike</option>
                            </select>
                            @error('service_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price Range -->
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <div>
                                <label for="price_from" class="block text-sm font-medium text-gray-700">Price From (₹)</label>
                                <input type="number" 
                                       name="price_from" 
                                       id="price_from" 
                                       value="{{ old('price_from') }}"
                                       min="0"
                                       step="0.01"
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('price_from') border-red-300 @enderror"
                                       placeholder="8000">
                                @error('price_from')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="price_to" class="block text-sm font-medium text-gray-700">Price To (₹)</label>
                                <input type="number" 
                                       name="price_to" 
                                       id="price_to" 
                                       value="{{ old('price_to') }}"
                                       min="0"
                                       step="0.01"
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('price_to') border-red-300 @enderror"
                                       placeholder="25000">
                                @error('price_to')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Service Image</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload a file</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </div>
                            @error('image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Detailed Content</h3>
                        <p class="mt-1 text-sm text-gray-500">Add detailed information about the service.</p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2 space-y-6">
                        <!-- Content -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">Full Content</label>
                            <textarea name="content" 
                                      id="content" 
                                      rows="8"
                                      class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('content') border-red-300 @enderror"
                                      placeholder="Enter detailed description of the service, including features, benefits, process, etc. You can use HTML tags.">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">You can use HTML tags for formatting.</p>
                        </div>

                        <!-- Features -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Service Features</label>
                            <div id="features-container" class="mt-2 space-y-2">
                                <div class="flex items-center space-x-2">
                                    <input type="text" 
                                           name="features[]" 
                                           value="{{ old('features.0') }}"
                                           class="flex-1 focus:ring-blue-500 focus:border-blue-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
                                           placeholder="e.g., Door-to-door service">
                                    <button type="button" onclick="removeFeature(this)" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <button type="button" onclick="addFeature()" class="mt-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Feature
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings & SEO -->
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Settings & SEO</h3>
                        <p class="mt-1 text-sm text-gray-500">Configure visibility and SEO settings.</p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2 space-y-6">
                        <!-- Status and Sort Order -->
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <div>
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           name="is_active" 
                                           id="is_active" 
                                           value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}
                                           class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                        Active Service
                                    </label>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Check to make this service visible on the website</p>
                            </div>

                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                                <input type="number" 
                                       name="sort_order" 
                                       id="sort_order" 
                                       value="{{ old('sort_order', 0) }}"
                                       min="0"
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('sort_order') border-red-300 @enderror"
                                       placeholder="0">
                                @error('sort_order')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- SEO Fields -->
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                            <input type="text" 
                                   name="meta_title" 
                                   id="meta_title" 
                                   value="{{ old('meta_title') }}"
                                   class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('meta_title') border-red-300 @enderror"
                                   placeholder="SEO title for search engines">
                            @error('meta_title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
                            <textarea name="meta_description" 
                                      id="meta_description" 
                                      rows="2"
                                      class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('meta_description') border-red-300 @enderror"
                                      placeholder="SEO description for search engines (max 160 characters)">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.services.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Create Service
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function addFeature() {
    const container = document.getElementById('features-container');
    const div = document.createElement('div');
    div.className = 'flex items-center space-x-2';
    div.innerHTML = `
        <input type="text" 
               name="features[]" 
               class="flex-1 focus:ring-blue-500 focus:border-blue-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
               placeholder="e.g., Professional drivers">
        <button type="button" onclick="removeFeature(this)" class="text-red-500 hover:text-red-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>
    `;
    container.appendChild(div);
}

function removeFeature(button) {
    button.parentElement.remove();
}
</script>
@endsection