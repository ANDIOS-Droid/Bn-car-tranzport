@extends('admin.layouts.app')

@section('title', 'Quote Request Details')
@section('page-title', 'Quote Request Details')

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Quote Request #{{ $quoteRequest->id }}</h2>
                <p class="text-sm text-gray-600">Manage quote request and send quotes to customers</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.quote-requests.edit', $quoteRequest) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Edit Quote
                </a>
                <a href="{{ route('admin.quote-requests.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Back to List
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Quote Details -->
            <div class="lg:col-span-2">
                <!-- Customer Information -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Customer Information</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Contact details and personal information</p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $quoteRequest->name }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <a href="mailto:{{ $quoteRequest->email }}" class="text-blue-600 hover:text-blue-800">{{ $quoteRequest->email }}</a>
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <a href="tel:{{ $quoteRequest->phone }}" class="text-blue-600 hover:text-blue-800">{{ $quoteRequest->phone }}</a>
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Transport Type</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ ucfirst($quoteRequest->transport_type) }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Route Information -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Transport Route</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Pickup and delivery locations</p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Pickup Location</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <strong>{{ $quoteRequest->pickup_city }}, {{ $quoteRequest->pickup_state }}</strong>
                                    </div>
                                    @if($quoteRequest->pickup_address)
                                        <p class="text-gray-600 ml-6 mt-1">{{ $quoteRequest->pickup_address }}</p>
                                    @endif
                                    @if($quoteRequest->pickup_date)
                                        <p class="text-gray-500 ml-6 mt-1 text-xs">Pickup Date: {{ \Carbon\Carbon::parse($quoteRequest->pickup_date)->format('M d, Y') }}</p>
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Delivery Location</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <strong>{{ $quoteRequest->delivery_city }}, {{ $quoteRequest->delivery_state }}</strong>
                                    </div>
                                    @if($quoteRequest->delivery_address)
                                        <p class="text-gray-600 ml-6 mt-1">{{ $quoteRequest->delivery_address }}</p>
                                    @endif
                                    @if($quoteRequest->delivery_date)
                                        <p class="text-gray-500 ml-6 mt-1 text-xs">Delivery Date: {{ \Carbon\Carbon::parse($quoteRequest->delivery_date)->format('M d, Y') }}</p>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Vehicle Information -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Vehicle Details</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Information about the vehicle to be transported</p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            @if($quoteRequest->vehicle_make || $quoteRequest->vehicle_model)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Vehicle Make & Model</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $quoteRequest->vehicle_make }} {{ $quoteRequest->vehicle_model }}
                                    @if($quoteRequest->vehicle_year)
                                        <span class="text-gray-500">({{ $quoteRequest->vehicle_year }})</span>
                                    @endif
                                </dd>
                            </div>
                            @endif
                            
                            @if($quoteRequest->vehicle_condition)
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Vehicle Condition</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($quoteRequest->vehicle_condition === 'running') bg-green-100 text-green-800
                                        @elseif($quoteRequest->vehicle_condition === 'non_running') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $quoteRequest->vehicle_condition)) }}
                                    </span>
                                </dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Additional Requirements -->
                @if($quoteRequest->additional_requirements)
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Additional Requirements</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Special requests and notes from customer</p>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $quoteRequest->additional_requirements }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Quote Management Sidebar -->
            <div class="lg:col-span-1">
                <!-- Status Card -->
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quote Status</h3>
                    
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'reviewed' => 'bg-orange-100 text-orange-800',
                            'quoted' => 'bg-blue-100 text-blue-800',
                            'accepted' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            'completed' => 'bg-purple-100 text-purple-800',
                        ];
                    @endphp
                    
                    <div class="flex items-center justify-center mb-4">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $statusColors[$quoteRequest->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($quoteRequest->status) }}
                        </span>
                    </div>

                    @if($quoteRequest->quoted_price)
                        <div class="text-center mb-4">
                            <p class="text-sm text-gray-500">Quoted Price</p>
                            <p class="text-2xl font-bold text-green-600">₹{{ number_format($quoteRequest->quoted_price) }}</p>
                            @if($quoteRequest->quoted_at)
                                <p class="text-xs text-gray-400">Quoted {{ $quoteRequest->quoted_at->diffForHumans() }}</p>
                            @endif
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="space-y-3">
                        @if($quoteRequest->status === 'pending')
                            <form action="{{ route('admin.quote-requests.update-status', $quoteRequest) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="reviewed">
                                <button type="submit" class="w-full bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700 transition">
                                    Mark as Reviewed
                                </button>
                            </form>
                        @elseif($quoteRequest->status === 'reviewed')
                            <button onclick="openQuoteModal()" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                Send Quote
                            </button>
                        @elseif($quoteRequest->status === 'quoted')
                            <div class="text-center text-blue-600 font-medium">Quote Sent - Awaiting Response</div>
                        @endif

                        @if(in_array($quoteRequest->status, ['quoted', 'accepted']))
                            <form action="{{ route('admin.quote-requests.update-status', $quoteRequest) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="w-full bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition">
                                    Mark as Completed
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Assignment Card -->
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Assignment</h3>
                    
                    @if($quoteRequest->assignedTo)
                        <div class="flex items-center mb-4">
                            <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $quoteRequest->assignedTo->name }}</p>
                                <p class="text-sm text-gray-500">{{ $quoteRequest->assignedTo->email }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 mb-4">Not assigned</p>
                    @endif

                    <form action="{{ route('admin.quote-requests.assign', $quoteRequest) }}" method="POST">
                        @csrf
                        <select name="user_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 mb-3">
                            <option value="">Select Admin</option>
                            @foreach($admins as $admin)
                                <option value="{{ $admin->id }}" {{ $quoteRequest->user_id == $admin->id ? 'selected' : '' }}>
                                    {{ $admin->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                            {{ $quoteRequest->assignedTo ? 'Reassign' : 'Assign' }}
                        </button>
                    </form>
                </div>

                <!-- Timeline Card -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Timeline</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                            <div>
                                <p class="text-sm font-medium">Quote Submitted</p>
                                <p class="text-xs text-gray-500">{{ $quoteRequest->created_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                        
                        @if($quoteRequest->quoted_at)
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                            <div>
                                <p class="text-sm font-medium">Quote Sent</p>
                                <p class="text-xs text-gray-500">{{ $quoteRequest->quoted_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Notes Section -->
        @if($quoteRequest->admin_notes)
        <div class="mt-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Admin Notes</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $quoteRequest->admin_notes }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Quote Modal -->
<div id="quoteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" style="z-index: 1000;">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Send Quote to Customer</h3>
            <form action="{{ route('admin.quote-requests.send-quote', $quoteRequest) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="quoted_price" class="block text-sm font-medium text-gray-700">Quote Price (₹)</label>
                    <input type="number" 
                           name="quoted_price" 
                           id="quoted_price" 
                           required
                           min="0"
                           step="0.01"
                           value="{{ $quoteRequest->quoted_price }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="quote_details" class="block text-sm font-medium text-gray-700">Quote Details</label>
                    <textarea name="quote_details" 
                              id="quote_details" 
                              rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                              placeholder="Additional details about the quote...">{{ $quoteRequest->admin_notes }}</textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeQuoteModal()" 
                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Send Quote
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openQuoteModal() {
    document.getElementById('quoteModal').classList.remove('hidden');
}

function closeQuoteModal() {
    document.getElementById('quoteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('quoteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeQuoteModal();
    }
});
</script>
@endsection