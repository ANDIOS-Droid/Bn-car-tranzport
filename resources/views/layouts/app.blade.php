<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'Professional Car & Bike Transport Services') - {{ config('app.name', 'BN Car Transport') }}</title>
    <meta name="description" content="@yield('meta_description', 'Reliable car and bike transport services across India. Safe, secure, and affordable vehicle transportation with door-to-door delivery.')">
    <meta name="keywords" content="@yield('meta_keywords', 'car transport, bike transport, vehicle shipping, car carrier, bike carrier, automobile transport, India')">
    <meta name="author" content="BN Car Transport">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'BN Car Transport - Professional Vehicle Transportation')">
    <meta property="og:description" content="@yield('og_description', 'Safe and reliable car & bike transport services across India with professional handling and timely delivery.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="BN Car Transport">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'BN Car Transport - Professional Vehicle Transportation')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Safe and reliable car & bike transport services across India.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/og-default.jpg'))">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical', url()->current())">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @stack('styles')
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "BN Car Transport",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/logo.png') }}",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+91-9876543210",
            "contactType": "customer service",
            "availableLanguage": ["English", "Hindi"]
        },
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "IN"
        },
        "sameAs": [
            "https://www.facebook.com/bncarransport",
            "https://www.twitter.com/bncarransport",
            "https://www.linkedin.com/company/bncarransport"
        ]
    }
    </script>
</head>
<body class="font-sans antialiased bg-white">
    <!-- Skip to main content link for accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded">
        Skip to main content
    </a>

    <!-- Top Header Bar -->
    <div class="bg-gray-900 text-white py-2 hidden md:block">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center text-sm">
                <div class="flex items-center space-x-6">
                    <span class="flex items-center">
                        <i class="fas fa-phone mr-2"></i>
                        <a href="tel:+919876543210" class="hover:text-blue-300">+91 98765 43210</a>
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        <a href="mailto:info@bncarransport.com" class="hover:text-blue-300">info@bncarransport.com</a>
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="flex items-center">
                        <i class="fas fa-clock mr-2"></i>
                        Mon - Sat: 9:00 AM - 7:00 PM
                    </span>
                    <div class="flex space-x-2">
                        <a href="#" class="text-white hover:text-blue-300"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white hover:text-blue-300"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white hover:text-blue-300"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-white hover:text-blue-300"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-truck text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">BN Car Transport</h1>
                            <p class="text-sm text-gray-600">Reliable Vehicle Transportation</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium transition duration-300 {{ request()->routeIs('home') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('services') }}" class="text-gray-700 hover:text-blue-600 font-medium transition duration-300 {{ request()->routeIs('services*') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">
                        Services
                    </a>
                    <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-blue-600 font-medium transition duration-300 {{ request()->routeIs('blog.*') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">
                        Blog
                    </a>
                    <a href="{{ route('gallery') }}" class="text-gray-700 hover:text-blue-600 font-medium transition duration-300 {{ request()->routeIs('gallery') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">
                        Gallery
                    </a>
                    <a href="{{ route('testimonials') }}" class="text-gray-700 hover:text-blue-600 font-medium transition duration-300 {{ request()->routeIs('testimonials') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">
                        Reviews
                    </a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 font-medium transition duration-300 {{ request()->routeIs('contact') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">
                        Contact
                    </a>
                </div>

                <!-- CTA Button -->
                <div class="hidden lg:flex items-center space-x-4">
                    <a href="{{ route('quote') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-300 shadow-lg hover:shadow-xl">
                        <i class="fas fa-calculator mr-2"></i>
                        Get Quote
                    </a>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                                <i class="fas fa-tachometer-alt mr-1"></i>
                                Admin
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                            <i class="fas fa-sign-in-alt mr-1"></i>
                            Login
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-blue-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div x-show="mobileMenuOpen" x-transition class="lg:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 bg-gray-50 rounded-lg mb-4">
                    <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Home</a>
                    <a href="{{ route('services') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Services</a>
                    <a href="{{ route('blog.index') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Blog</a>
                    <a href="{{ route('gallery') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Gallery</a>
                    <a href="{{ route('testimonials') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Reviews</a>
                    <a href="{{ route('contact') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Contact</a>
                    <div class="border-t border-gray-200 pt-3">
                        <a href="{{ route('quote') }}" class="block bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg font-semibold text-center">
                            Get Quote
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main id="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-truck text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold">BN Car Transport</h3>
                    </div>
                    <p class="text-gray-300 leading-relaxed">
                        Professional car and bike transport services across India. We ensure safe, secure, and timely delivery of your vehicles with complete peace of mind.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-blue-400 transition duration-300">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-blue-400 transition duration-300">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-blue-400 transition duration-300">
                            <i class="fab fa-linkedin-in text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-blue-400 transition duration-300">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-blue-400 transition duration-300">Home</a></li>
                        <li><a href="{{ route('services') }}" class="text-gray-300 hover:text-blue-400 transition duration-300">Our Services</a></li>
                        <li><a href="{{ route('quote') }}" class="text-gray-300 hover:text-blue-400 transition duration-300">Get Quote</a></li>
                        <li><a href="{{ route('gallery') }}" class="text-gray-300 hover:text-blue-400 transition duration-300">Gallery</a></li>
                        <li><a href="{{ route('testimonials') }}" class="text-gray-300 hover:text-blue-400 transition duration-300">Customer Reviews</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-blue-400 transition duration-300">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Our Services</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-blue-400 transition duration-300">Car Transportation</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-blue-400 transition duration-300">Bike Transportation</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-blue-400 transition duration-300">Express Delivery</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-blue-400 transition duration-300">Door-to-Door Service</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-blue-400 transition duration-300">Insurance Coverage</a></li>
                        <li><a href="{{ route('blog.index') }}" class="text-gray-300 hover:text-blue-400 transition duration-300">Blog & Tips</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Contact Info</h3>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-map-marker-alt text-blue-400 mt-1"></i>
                            <div>
                                <p class="text-gray-300">123 Transport Street, Business District</p>
                                <p class="text-gray-300">New Delhi - 110001, India</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone text-blue-400"></i>
                            <a href="tel:+919876543210" class="text-gray-300 hover:text-blue-400 transition duration-300">+91 98765 43210</a>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-blue-400"></i>
                            <a href="mailto:info@bncarransport.com" class="text-gray-300 hover:text-blue-400 transition duration-300">info@bncarransport.com</a>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-clock text-blue-400"></i>
                            <p class="text-gray-300">Mon - Sat: 9:00 AM - 7:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800">
            <div class="container mx-auto px-4 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-300 text-sm">
                        © {{ date('Y') }} BN Car Transport. All rights reserved.
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-300 hover:text-blue-400 text-sm transition duration-300">Privacy Policy</a>
                        <a href="#" class="text-gray-300 hover:text-blue-400 text-sm transition duration-300">Terms of Service</a>
                        <a href="#" class="text-gray-300 hover:text-blue-400 text-sm transition duration-300">Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg transition duration-300 opacity-0 invisible">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Additional Scripts -->
    @stack('scripts')
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Back to top functionality
        window.addEventListener('scroll', function() {
            const backToTop = document.getElementById('backToTop');
            if (window.pageYOffset > 300) {
                backToTop.classList.remove('opacity-0', 'invisible');
                backToTop.classList.add('opacity-100', 'visible');
            } else {
                backToTop.classList.add('opacity-0', 'invisible');
                backToTop.classList.remove('opacity-100', 'visible');
            }
        });

        document.getElementById('backToTop').addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>