<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Page;
use App\Models\Gallery;
use App\Models\QuoteRequest;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Services
        $services = [
            [
                'title' => 'Car Transportation',
                'slug' => 'car-transportation',
                'description' => 'Safe and reliable car transportation services across India',
                'content' => '<h3>Professional Car Transportation Services</h3><p>Our experienced team ensures your car reaches its destination safely and on time. We use specialized car carriers and provide door-to-door service.</p><ul><li>Door-to-door pickup and delivery</li><li>GPS tracking available</li><li>Insurance coverage included</li><li>Professional drivers</li></ul>',
                'price_from' => 8000.00,
                'price_to' => 25000.00,
                'features' => ['Door-to-door service', 'GPS tracking', 'Insurance coverage', 'Professional drivers'],
                'service_type' => 'car_transport',
                'is_active' => true,
                'sort_order' => 1,
                'meta_title' => 'Car Transportation Services - BN Car Transport',
                'meta_description' => 'Professional car transportation services across India. Safe, reliable, and affordable car transport solutions.',
            ],
            [
                'title' => 'Bike Transportation',
                'slug' => 'bike-transportation',
                'description' => 'Secure bike transport with professional handling',
                'content' => '<h3>Motorcycle Transportation Services</h3><p>We specialize in safe motorcycle transportation using specially designed bike carriers. Your bike will be securely fastened and protected during transit.</p><ul><li>Specialized bike carriers</li><li>Secure fastening systems</li><li>Protective covering</li><li>Experienced handlers</li></ul>',
                'price_from' => 3000.00,
                'price_to' => 12000.00,
                'features' => ['Specialized carriers', 'Secure fastening', 'Protective covering', 'Experienced handlers'],
                'service_type' => 'bike_transport',
                'is_active' => true,
                'sort_order' => 2,
                'meta_title' => 'Bike Transportation Services - BN Car Transport',
                'meta_description' => 'Secure motorcycle transportation services across major Indian cities. Professional bike transport solutions.',
            ],
            [
                'title' => 'Express Delivery',
                'slug' => 'express-delivery',
                'description' => 'Fast delivery service for urgent transportation needs',
                'content' => '<h3>Express Transportation Services</h3><p>Need your vehicle transported urgently? Our express service ensures faster delivery times without compromising on safety.</p><ul><li>Priority handling</li><li>Faster delivery times</li><li>24/7 tracking</li><li>Dedicated support</li></ul>',
                'price_from' => 12000.00,
                'price_to' => 35000.00,
                'features' => ['Priority handling', 'Faster delivery', '24/7 tracking', 'Dedicated support'],
                'service_type' => 'both',
                'is_active' => true,
                'sort_order' => 3,
                'meta_title' => 'Express Vehicle Transportation - BN Car Transport',
                'meta_description' => 'Fast and urgent vehicle transportation services. Express delivery for cars and bikes across India.',
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['slug' => $service['slug']], $service);
        }

        // Create Testimonials
        $testimonials = [
            [
                'name' => 'Rajesh Kumar',
                'email' => 'rajesh@example.com',
                'phone' => '+91 9876543210',
                'location' => 'Delhi to Mumbai',
                'message' => 'Excellent service! My car was delivered safely and on time. The team was very professional and kept me updated throughout the journey.',
                'rating' => 5,
                'service_used' => 'Car Transportation',
                'is_approved' => true,
                'is_featured' => true,
                'service_date' => now()->subDays(15),
            ],
            [
                'name' => 'Priya Sharma',
                'email' => 'priya@example.com',
                'phone' => '+91 9765432109',
                'location' => 'Bangalore to Chennai',
                'message' => 'Great experience with BN Car Transport. They handled my bike with care and delivered it without any damage. Highly recommended!',
                'rating' => 5,
                'service_used' => 'Bike Transportation',
                'is_approved' => true,
                'is_featured' => true,
                'service_date' => now()->subDays(8),
            ],
            [
                'name' => 'Amit Patel',
                'email' => 'amit@example.com',
                'phone' => '+91 9654321098',
                'location' => 'Pune to Hyderabad',
                'message' => 'Reliable and affordable service. The express delivery option worked perfectly for my urgent requirements. Will use again!',
                'rating' => 4,
                'service_used' => 'Express Delivery',
                'is_approved' => true,
                'is_featured' => false,
                'service_date' => now()->subDays(3),
            ],
            [
                'name' => 'Sunita Verma',
                'email' => 'sunita@example.com',
                'phone' => '+91 9543210987',
                'location' => 'Kolkata to Delhi',
                'message' => 'Professional team and excellent customer service. They took great care of my car during the long journey. Thank you!',
                'rating' => 5,
                'service_used' => 'Car Transportation',
                'is_approved' => true,
                'is_featured' => false,
                'service_date' => now()->subDays(20),
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::firstOrCreate(['email' => $testimonial['email']], $testimonial);
        }

        // Create Static Pages
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'content' => '<h2>About BN Car Transport</h2><p>BN Car Transport is a leading vehicle transportation company in India, providing safe and reliable car and bike transportation services across major cities. With years of experience in the logistics industry, we have built a reputation for excellence in vehicle transport services.</p><h3>Our Mission</h3><p>To provide safe, reliable, and affordable vehicle transportation services while ensuring customer satisfaction and maintaining the highest standards of service quality.</p><h3>Why Choose Us?</h3><ul><li>Experienced and professional team</li><li>Modern transportation equipment</li><li>Comprehensive insurance coverage</li><li>Real-time tracking system</li><li>24/7 customer support</li><li>Competitive pricing</li></ul>',
                'excerpt' => 'Leading vehicle transportation company providing safe and reliable services across India.',
                'is_published' => true,
                'show_in_menu' => true,
                'menu_order' => 1,
                'meta_title' => 'About BN Car Transport - Vehicle Transportation Services',
                'meta_description' => 'Learn about BN Car Transport, a leading vehicle transportation company in India providing safe and reliable car and bike transport services.',
                'template' => 'default',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'content' => '<h2>Get in Touch</h2><p>Ready to transport your vehicle? Contact us today for a free quote and let our experienced team handle your transportation needs.</p><h3>Contact Information</h3><p><strong>Phone:</strong> +91 9876543210<br><strong>Email:</strong> info@bncarransport.com<br><strong>Address:</strong> 123 Transport Street, Delhi, India</p><h3>Business Hours</h3><p>Monday - Saturday: 9:00 AM - 7:00 PM<br>Sunday: 10:00 AM - 5:00 PM</p>',
                'excerpt' => 'Contact BN Car Transport for all your vehicle transportation needs.',
                'is_published' => true,
                'show_in_menu' => true,
                'menu_order' => 2,
                'meta_title' => 'Contact BN Car Transport - Get a Free Quote',
                'meta_description' => 'Contact BN Car Transport for reliable vehicle transportation services. Get a free quote today!',
                'template' => 'contact',
            ],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(['slug' => $page['slug']], $page);
        }

        // Create Sample Quote Requests
        $quoteRequests = [
            [
                'name' => 'Arjun Singh',
                'email' => 'arjun@example.com',
                'phone' => '+91 9123456789',
                'transport_type' => 'car',
                'vehicle_make' => 'Maruti',
                'vehicle_model' => 'Swift',
                'vehicle_year' => '2019',
                'vehicle_condition' => 'running',
                'pickup_location' => 'Sector 15, Noida',
                'pickup_city' => 'Noida',
                'pickup_state' => 'Uttar Pradesh',
                'pickup_pincode' => '201301',
                'delivery_location' => 'Bandra West, Mumbai',
                'delivery_city' => 'Mumbai',
                'delivery_state' => 'Maharashtra',
                'delivery_pincode' => '400050',
                'pickup_date' => now()->addDays(5),
                'service_type' => 'door_to_door',
                'status' => 'pending',
            ],
            [
                'name' => 'Meera Joshi',
                'email' => 'meera@example.com',
                'phone' => '+91 9234567890',
                'transport_type' => 'bike',
                'vehicle_make' => 'Honda',
                'vehicle_model' => 'Activa',
                'vehicle_year' => '2020',
                'vehicle_condition' => 'running',
                'pickup_location' => 'MG Road, Bangalore',
                'pickup_city' => 'Bangalore',
                'pickup_state' => 'Karnataka',
                'pickup_pincode' => '560001',
                'delivery_location' => 'Anna Nagar, Chennai',
                'delivery_city' => 'Chennai',
                'delivery_state' => 'Tamil Nadu',
                'delivery_pincode' => '600040',
                'pickup_date' => now()->addDays(3),
                'service_type' => 'enclosed_carrier',
                'status' => 'quoted',
            ],
        ];

        foreach ($quoteRequests as $quote) {
            QuoteRequest::firstOrCreate(['email' => $quote['email']], $quote);
        }

        $this->command->info('Sample data created successfully!');
        $this->command->info('Created: 3 Services, 4 Testimonials, 2 Pages, 2 Quote Requests');
    }
}
