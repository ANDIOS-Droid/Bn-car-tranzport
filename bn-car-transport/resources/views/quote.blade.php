<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Quote - BN Car Transport</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Get a Quote</h1>
                <p class="text-gray-600 mt-2">Request a quote for your vehicle transportation needs</p>
                <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 mt-4 inline-block">← Back to Home</a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('quote.store') }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-6">
                @csrf
                
                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone *</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="transport_type" class="block text-sm font-medium text-gray-700">Transport Type *</label>
                            <select name="transport_type" id="transport_type" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select type</option>
                                <option value="car" {{ old('transport_type') == 'car' ? 'selected' : '' }}>Car</option>
                                <option value="bike" {{ old('transport_type') == 'bike' ? 'selected' : '' }}>Bike</option>
                                <option value="both" {{ old('transport_type') == 'both' ? 'selected' : '' }}>Both</option>
                            </select>
                            @error('transport_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Vehicle Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Vehicle Information</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div>
                            <label for="vehicle_make" class="block text-sm font-medium text-gray-700">Make</label>
                            <input type="text" name="vehicle_make" id="vehicle_make" value="{{ old('vehicle_make') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="vehicle_model" class="block text-sm font-medium text-gray-700">Model</label>
                            <input type="text" name="vehicle_model" id="vehicle_model" value="{{ old('vehicle_model') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="vehicle_year" class="block text-sm font-medium text-gray-700">Year</label>
                            <input type="text" name="vehicle_year" id="vehicle_year" value="{{ old('vehicle_year') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="vehicle_condition" class="block text-sm font-medium text-gray-700">Vehicle Condition *</label>
                        <select name="vehicle_condition" id="vehicle_condition" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select condition</option>
                            <option value="running" {{ old('vehicle_condition') == 'running' ? 'selected' : '' }}>Running</option>
                            <option value="non_running" {{ old('vehicle_condition') == 'non_running' ? 'selected' : '' }}>Non-Running</option>
                            <option value="damaged" {{ old('vehicle_condition') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                        </select>
                        @error('vehicle_condition')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Location Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Location Information</h3>
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <!-- Pickup Location -->
                        <div>
                            <h4 class="font-medium text-gray-900 mb-3">Pickup Location</h4>
                            <div class="space-y-3">
                                <div>
                                    <input type="text" name="pickup_location" placeholder="Pickup Address *" value="{{ old('pickup_location') }}" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('pickup_location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <input type="text" name="pickup_city" placeholder="City *" value="{{ old('pickup_city') }}" required
                                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <input type="text" name="pickup_state" placeholder="State *" value="{{ old('pickup_state') }}" required
                                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <input type="text" name="pickup_pincode" placeholder="Pincode *" value="{{ old('pickup_pincode') }}" required
                                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- Delivery Location -->
                        <div>
                            <h4 class="font-medium text-gray-900 mb-3">Delivery Location</h4>
                            <div class="space-y-3">
                                <div>
                                    <input type="text" name="delivery_location" placeholder="Delivery Address *" value="{{ old('delivery_location') }}" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('delivery_location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <input type="text" name="delivery_city" placeholder="City *" value="{{ old('delivery_city') }}" required
                                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <input type="text" name="delivery_state" placeholder="State *" value="{{ old('delivery_state') }}" required
                                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <input type="text" name="delivery_pincode" placeholder="Pincode *" value="{{ old('delivery_pincode') }}" required
                                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="pickup_date" class="block text-sm font-medium text-gray-700">Preferred Pickup Date</label>
                            <input type="date" name="pickup_date" id="pickup_date" value="{{ old('pickup_date') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="service_type" class="block text-sm font-medium text-gray-700">Service Type</label>
                            <select name="service_type" id="service_type"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="open_carrier" {{ old('service_type') == 'open_carrier' ? 'selected' : '' }}>Open Carrier</option>
                                <option value="enclosed_carrier" {{ old('service_type') == 'enclosed_carrier' ? 'selected' : '' }}>Enclosed Carrier</option>
                                <option value="door_to_door" {{ old('service_type') == 'door_to_door' ? 'selected' : '' }}>Door to Door</option>
                                <option value="terminal_to_terminal" {{ old('service_type') == 'terminal_to_terminal' ? 'selected' : '' }}>Terminal to Terminal</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="additional_requirements" class="block text-sm font-medium text-gray-700">Additional Requirements</label>
                        <textarea name="additional_requirements" id="additional_requirements" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Any special requirements or instructions...">{{ old('additional_requirements') }}</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit Quote Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>