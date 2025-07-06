<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote Submitted Successfully - BN Car Transport</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 text-center">
            <div>
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100">
                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Quote Request Submitted!
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Thank you for choosing BN Car Transport
                </p>
            </div>
            
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">What Happens Next?</h3>
                <div class="space-y-4 text-left">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-600 text-sm font-medium">
                                1
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Review & Assessment</p>
                            <p class="text-sm text-gray-600">Our team will review your quote request within 2-4 hours</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-600 text-sm font-medium">
                                2
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Personalized Quote</p>
                            <p class="text-sm text-gray-600">We'll prepare a detailed quote based on your requirements</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-600 text-sm font-medium">
                                3
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Contact & Confirmation</p>
                            <p class="text-sm text-gray-600">Our representative will contact you to discuss details</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">
                            Need immediate assistance?
                        </h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Call us at <span class="font-medium">+91 9876543210</span></p>
                            <p>Email: <span class="font-medium">info@bncarransport.com</span></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('home') }}" 
                   class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Back to Home
                </a>
                <a href="{{ route('quote') }}" 
                   class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Submit Another Quote
                </a>
            </div>
        </div>
    </div>
</body>
</html>