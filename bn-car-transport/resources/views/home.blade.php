<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BN Car Transport - Professional Vehicle Transportation Services</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md mx-auto text-center">
            <div class="mb-8">
                <svg class="mx-auto h-16 w-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">BN Car Transport</h1>
            <p class="text-xl text-gray-600 mb-8">Professional Vehicle Transportation Services</p>
            <div class="space-y-4">
                <p class="text-gray-700">The public website frontend is under development.</p>
                <p class="text-gray-700">Admin Dashboard is ready and functional!</p>
                <div class="flex justify-center space-x-4 mt-8">
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Admin Login
                    </a>
                    <a href="{{ route('quote') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Get Quote
                    </a>
                </div>
            </div>
            
            @if($services->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Our Services</h2>
                    <div class="grid gap-4">
                        @foreach($services as $service)
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h3 class="font-semibold text-gray-900">{{ $service->title }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $service->description }}</p>
                                @if($service->price_from && $service->price_to)
                                    <p class="text-green-600 font-medium mt-2">
                                        ₹{{ number_format($service->price_from) }} - ₹{{ number_format($service->price_to) }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>