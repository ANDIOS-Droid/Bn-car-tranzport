<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create blog categories
        $categories = [
            [
                'name' => 'Car Transport Tips',
                'slug' => 'car-transport-tips',
                'description' => 'Helpful tips and guides for car transportation and vehicle shipping.',
                'color' => '#3B82F6',
                'meta_title' => 'Car Transport Tips & Guides',
                'meta_description' => 'Expert tips and comprehensive guides for safe and efficient car transportation services.',
            ],
            [
                'name' => 'Bike Transport',
                'slug' => 'bike-transport',
                'description' => 'Everything about motorcycle and bike transportation services.',
                'color' => '#10B981',
                'meta_title' => 'Bike Transport Services & Tips',
                'meta_description' => 'Complete guide to motorcycle and bike transportation services across India.',
            ],
            [
                'name' => 'Industry News',
                'slug' => 'industry-news',
                'description' => 'Latest news and updates from the vehicle transportation industry.',
                'color' => '#F59E0B',
                'meta_title' => 'Vehicle Transport Industry News',
                'meta_description' => 'Stay updated with the latest news and trends in the vehicle transportation industry.',
            ],
            [
                'name' => 'Travel Guides',
                'slug' => 'travel-guides',
                'description' => 'Travel guides and route information for vehicle transportation.',
                'color' => '#EF4444',
                'meta_title' => 'Vehicle Transport Route Guides',
                'meta_description' => 'Comprehensive travel guides and route information for vehicle transportation across India.',
            ],
            [
                'name' => 'Customer Stories',
                'slug' => 'customer-stories',
                'description' => 'Real customer experiences and success stories.',
                'color' => '#8B5CF6',
                'meta_title' => 'Customer Success Stories',
                'meta_description' => 'Read real customer experiences and success stories from BN Car Transport services.',
            ],
        ];

        foreach ($categories as $categoryData) {
            BlogCategory::create($categoryData);
        }

        // Get admin user for blog posts
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            // Create a default admin if none exists
            $admin = User::create([
                'name' => 'BN Car Transport',
                'email' => 'admin@bncarransport.com',
                'password' => bcrypt('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }

        // Get created categories
        $carTipsCategory = BlogCategory::where('slug', 'car-transport-tips')->first();
        $bikeTipsCategory = BlogCategory::where('slug', 'bike-transport')->first();
        $newsCategory = BlogCategory::where('slug', 'industry-news')->first();
        $travelCategory = BlogCategory::where('slug', 'travel-guides')->first();
        $storiesCategory = BlogCategory::where('slug', 'customer-stories')->first();

        // Create sample blog posts
        $posts = [
            // Car Transport Tips
            [
                'title' => 'Complete Guide to Car Transportation: Everything You Need to Know',
                'slug' => 'complete-guide-car-transportation',
                'excerpt' => 'Discover everything you need to know about car transportation services, from choosing the right carrier to preparing your vehicle for shipping.',
                'content' => '<h2>Introduction to Car Transportation</h2>
                
<p>Car transportation has become an essential service for people relocating, buying vehicles from distant locations, or simply needing to move their cars safely across long distances. Whether you\'re moving to a new city, purchasing a car from another state, or relocating for work, professional car transportation services provide a convenient and safe solution.</p>

<h2>Types of Car Transportation Services</h2>

<h3>1. Open Carrier Transport</h3>
<p>Open carrier transport is the most common and cost-effective method of car shipping. Your vehicle is loaded onto an open trailer along with other cars. While this method exposes your car to weather conditions, it\'s perfectly safe for most vehicles and significantly more affordable.</p>

<h3>2. Enclosed Carrier Transport</h3>
<p>For luxury, classic, or high-value vehicles, enclosed carrier transport provides maximum protection. Your car is shipped in a covered trailer, protecting it from weather, dust, and road debris.</p>

<h3>3. Door-to-Door Service</h3>
<p>Door-to-door service means the carrier picks up your vehicle from your specified location and delivers it directly to your destination. This is the most convenient option, though it may cost slightly more.</p>

<h3>4. Terminal-to-Terminal Service</h3>
<p>With terminal-to-terminal service, you drop off your vehicle at a designated terminal and pick it up from another terminal near your destination. This option is typically more affordable but less convenient.</p>

<h2>Preparing Your Car for Transportation</h2>

<h3>1. Clean Your Vehicle</h3>
<p>Thoroughly wash your car before transportation. This makes it easier to identify any existing damage and document the vehicle\'s condition.</p>

<h3>2. Remove Personal Items</h3>
<p>Remove all personal belongings from your car. Most transportation companies are not liable for personal items, and extra weight can incur additional charges.</p>

<h3>3. Document Existing Damage</h3>
<p>Take detailed photos of your vehicle from all angles, noting any existing scratches, dents, or damage. This documentation will be crucial if you need to file an insurance claim.</p>

<h3>4. Check Fluid Levels and Battery</h3>
<p>Ensure your car has adequate fluids and a working battery. However, keep the fuel tank no more than 1/4 full to reduce weight and comply with safety regulations.</p>

<h2>Choosing the Right Transportation Company</h2>

<h3>Research and Reviews</h3>
<p>Research potential transportation companies thoroughly. Read customer reviews, check their Better Business Bureau rating, and verify their licensing and insurance credentials.</p>

<h3>Get Multiple Quotes</h3>
<p>Obtain quotes from at least three different companies. Be wary of quotes that are significantly lower than others, as they may indicate poor service quality or hidden fees.</p>

<h3>Insurance Coverage</h3>
<p>Verify the company\'s insurance coverage and understand what damages are covered. Consider purchasing additional insurance if your vehicle is particularly valuable.</p>

<h2>Understanding the Costs</h2>

<p>Several factors affect car transportation costs:</p>
<ul>
<li><strong>Distance:</strong> Longer distances generally cost more</li>
<li><strong>Vehicle size:</strong> Larger vehicles cost more to transport</li>
<li><strong>Transport type:</strong> Enclosed transport costs more than open transport</li>
<li><strong>Season:</strong> Summer months typically have higher rates</li>
<li><strong>Route popularity:</strong> Common routes are usually less expensive</li>
</ul>

<h2>Timeline and Scheduling</h2>

<p>Car transportation typically takes 1-2 weeks for cross-country shipments, depending on the distance and route. Popular routes may have faster service, while remote locations might take longer. Book your shipment at least 2-3 weeks in advance, especially during peak seasons.</p>

<h2>What to Expect During Transportation</h2>

<h3>Pickup Process</h3>
<p>During pickup, the driver will inspect your vehicle and create a bill of lading documenting its condition. Review this document carefully and ensure all existing damage is noted before signing.</p>

<h3>Tracking Your Shipment</h3>
<p>Many companies provide tracking services so you can monitor your vehicle\'s progress. However, updates may not be real-time, so don\'t worry if you don\'t hear from them daily.</p>

<h3>Delivery Process</h3>
<p>Upon delivery, inspect your vehicle thoroughly before signing the bill of lading. If you notice any new damage, document it immediately and report it to the transportation company.</p>

<h2>Tips for a Smooth Experience</h2>

<ul>
<li>Book early, especially during peak moving seasons</li>
<li>Read the contract carefully and understand the terms</li>
<li>Keep all documentation and photos</li>
<li>Communicate clearly with your transportation coordinator</li>
<li>Be flexible with pickup and delivery dates when possible</li>
<li>Ensure someone is available to receive the vehicle at delivery</li>
</ul>

<h2>Common Mistakes to Avoid</h2>

<ul>
<li>Choosing a company based solely on price</li>
<li>Not researching the company\'s reputation</li>
<li>Failing to document the vehicle\'s condition</li>
<li>Leaving personal items in the car</li>
<li>Not understanding the insurance coverage</li>
<li>Booking too close to your required dates</li>
</ul>

<h2>Conclusion</h2>

<p>Car transportation can be a stress-free experience when you choose the right company and prepare properly. Take time to research your options, understand the process, and prepare your vehicle accordingly. With proper planning and the right transportation partner, your vehicle will arrive safely at its destination.</p>

<p>Remember, the cheapest option isn\'t always the best. Invest in a reputable company with good reviews and proper insurance coverage to ensure your vehicle is in good hands throughout the transportation process.</p>',
                'blog_category_id' => $carTipsCategory->id,
                'user_id' => $admin->id,
                'status' => 'published',
                'published_at' => now()->subDays(15),
                'is_featured' => true,
                'tags' => ['car transport', 'shipping', 'guide', 'tips'],
                'reading_time' => '8 min read',
                'meta_title' => 'Complete Guide to Car Transportation Services 2024',
                'meta_description' => 'Everything you need to know about car transportation services. Learn about types, costs, preparation tips, and how to choose the right carrier.',
                'meta_keywords' => 'car transportation, vehicle shipping, car carrier, auto transport',
                'og_title' => 'Complete Guide to Car Transportation',
                'og_description' => 'Discover everything about car transportation services, from choosing carriers to preparing your vehicle for shipping.',
            ],
            
            // Bike Transport
            [
                'title' => 'Motorcycle Transportation: Safe and Secure Bike Shipping Solutions',
                'slug' => 'motorcycle-transportation-safe-shipping',
                'excerpt' => 'Learn about professional motorcycle transportation services and how to safely ship your bike across long distances.',
                'content' => '<h2>Why Choose Professional Motorcycle Transportation?</h2>

<p>Motorcycles require special care during transportation due to their unique design and vulnerability. Professional motorcycle transportation services provide specialized equipment and expertise to ensure your bike arrives safely at its destination.</p>

<h2>Types of Motorcycle Transportation</h2>

<h3>1. Crated Shipping</h3>
<p>For maximum protection, motorcycles can be crated for shipping. This method provides the highest level of security but is typically more expensive.</p>

<h3>2. Pallet Shipping</h3>
<p>Motorcycles are secured to pallets for transportation. This method offers good protection at a more affordable price point.</p>

<h3>3. Trailer Transport</h3>
<p>Multiple motorcycles are loaded onto specialized trailers with secure tie-down systems. This is often the most cost-effective option for standard motorcycles.</p>

<h2>Preparing Your Motorcycle for Transportation</h2>

<h3>Essential Preparation Steps</h3>
<ul>
<li>Clean your motorcycle thoroughly</li>
<li>Remove all personal items and accessories</li>
<li>Drain the fuel tank to 1/4 capacity or less</li>
<li>Disconnect the battery</li>
<li>Check tire pressure and inflate to recommended levels</li>
<li>Document existing damage with photos</li>
<li>Remove or secure loose parts</li>
</ul>

<h2>Cost Factors for Motorcycle Transportation</h2>

<p>Several factors influence motorcycle shipping costs:</p>
<ul>
<li>Distance and route</li>
<li>Size and weight of the motorcycle</li>
<li>Type of transportation service</li>
<li>Season and demand</li>
<li>Pickup and delivery locations</li>
<li>Insurance coverage level</li>
</ul>

<h2>Insurance and Protection</h2>

<p>Ensure your motorcycle is properly insured during transportation. Most professional carriers provide basic coverage, but consider additional insurance for high-value bikes.</p>

<h2>Choosing the Right Motorcycle Carrier</h2>

<h3>Key Selection Criteria</h3>
<ul>
<li>Experience with motorcycle transportation</li>
<li>Proper licensing and insurance</li>
<li>Specialized equipment for motorcycles</li>
<li>Positive customer reviews</li>
<li>Clear contract terms</li>
<li>Competitive pricing</li>
</ul>

<p>At BN Car Transport, we specialize in safe and secure motorcycle transportation across India. Our experienced team uses specialized equipment and follows strict safety protocols to ensure your bike arrives in perfect condition.</p>',
                'blog_category_id' => $bikeTipsCategory->id,
                'user_id' => $admin->id,
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'is_featured' => false,
                'tags' => ['motorcycle', 'bike transport', 'shipping', 'safety'],
                'reading_time' => '5 min read',
                'meta_title' => 'Motorcycle Transportation Services - Safe Bike Shipping',
                'meta_description' => 'Professional motorcycle transportation services. Learn about safe bike shipping methods, preparation tips, and costs.',
                'meta_keywords' => 'motorcycle transport, bike shipping, motorcycle carrier',
            ],

            // Industry News
            [
                'title' => 'The Future of Vehicle Transportation: Technology and Innovation Trends',
                'slug' => 'future-vehicle-transportation-technology-trends',
                'excerpt' => 'Explore the latest technology trends shaping the vehicle transportation industry, from GPS tracking to electric carriers.',
                'content' => '<h2>Digital Transformation in Vehicle Transportation</h2>

<p>The vehicle transportation industry is undergoing a significant digital transformation. Modern technology is revolutionizing how we track, manage, and execute vehicle shipments, making the process more efficient and transparent than ever before.</p>

<h2>GPS Tracking and Real-Time Updates</h2>

<p>Advanced GPS tracking systems now provide real-time location updates for transported vehicles. Customers can track their shipments online, receiving automated notifications about pickup, transit milestones, and delivery updates.</p>

<h2>Digital Documentation and Paperless Processes</h2>

<p>The industry is moving towards digital documentation, including electronic bills of lading, digital damage reports, and online contract signing. This reduces paperwork, speeds up processes, and improves accuracy.</p>

<h2>Electric and Hybrid Carriers</h2>

<p>Environmental consciousness is driving the adoption of electric and hybrid transport carriers. These vehicles reduce emissions and operating costs while maintaining the same level of service quality.</p>

<h2>Artificial Intelligence and Route Optimization</h2>

<p>AI-powered systems optimize routes, predict delivery times, and improve fleet management. This technology helps reduce costs, improve efficiency, and provide more accurate delivery estimates.</p>

<h2>Enhanced Safety Features</h2>

<p>Modern carriers are equipped with advanced safety features including collision avoidance systems, fatigue monitoring, and automated emergency braking systems to ensure maximum safety for transported vehicles.</p>

<h2>Customer Experience Improvements</h2>

<p>Digital platforms provide seamless booking experiences, instant quotes, and 24/7 customer support through chatbots and mobile applications.</p>

<p>The future of vehicle transportation is bright, with technology making the process more efficient, transparent, and environmentally friendly than ever before.</p>',
                'blog_category_id' => $newsCategory->id,
                'user_id' => $admin->id,
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'is_featured' => true,
                'tags' => ['technology', 'innovation', 'industry trends', 'future'],
                'reading_time' => '4 min read',
                'meta_title' => 'Future of Vehicle Transportation Technology Trends',
                'meta_description' => 'Discover the latest technology trends transforming the vehicle transportation industry, from GPS tracking to AI optimization.',
            ],

            // Travel Guide
            [
                'title' => 'Delhi to Mumbai Vehicle Transport: Complete Route Guide',
                'slug' => 'delhi-mumbai-vehicle-transport-route-guide',
                'excerpt' => 'Everything you need to know about transporting vehicles from Delhi to Mumbai, including routes, timing, and costs.',
                'content' => '<h2>Delhi to Mumbai: One of India\'s Most Popular Transport Routes</h2>

<p>The Delhi to Mumbai route is one of the busiest vehicle transportation corridors in India. This comprehensive guide covers everything you need to know about shipping your vehicle between these two major cities.</p>

<h2>Route Options and Distance</h2>

<h3>Primary Route via NH48</h3>
<p>The main route covers approximately 1,400 kilometers via National Highway 48, passing through Gurgaon, Jaipur, Ajmer, Udaipur, Ahmedabad, and Vadodara before reaching Mumbai.</p>

<h3>Alternative Routes</h3>
<p>Alternative routes are available via Indore and Nashik, which may be used depending on traffic conditions and carrier schedules.</p>

<h2>Transportation Timeline</h2>

<ul>
<li><strong>Standard Service:</strong> 5-7 days</li>
<li><strong>Express Service:</strong> 3-4 days</li>
<li><strong>Economy Service:</strong> 7-10 days</li>
</ul>

<h2>Cost Factors</h2>

<p>Transportation costs vary based on:</p>
<ul>
<li>Vehicle type and size</li>
<li>Service level (standard, express, economy)</li>
<li>Pickup and delivery locations</li>
<li>Season and demand</li>
<li>Insurance coverage</li>
</ul>

<h2>Popular Pickup and Delivery Areas</h2>

<h3>Delhi NCR Areas</h3>
<ul>
<li>Central Delhi</li>
<li>Gurgaon</li>
<li>Noida</li>
<li>Faridabad</li>
<li>Ghaziabad</li>
</ul>

<h3>Mumbai Areas</h3>
<ul>
<li>South Mumbai</li>
<li>Western Suburbs</li>
<li>Central Mumbai</li>
<li>Navi Mumbai</li>
<li>Thane</li>
</ul>

<h2>Best Time to Ship</h2>

<p>The best time for vehicle transportation on this route is during October to March when weather conditions are favorable and monsoon-related delays are avoided.</p>

<h2>Documentation Required</h2>

<ul>
<li>Vehicle registration certificate</li>
<li>Insurance documents</li>
<li>Identity proof</li>
<li>Address proof</li>
<li>NOC (if required)</li>
</ul>

<h2>Tips for Delhi to Mumbai Vehicle Transport</h2>

<ul>
<li>Book at least 1-2 weeks in advance</li>
<li>Choose reputable carriers with experience on this route</li>
<li>Ensure proper insurance coverage</li>
<li>Document vehicle condition before shipping</li>
<li>Keep important documents handy</li>
</ul>

<p>BN Car Transport offers reliable Delhi to Mumbai vehicle transportation services with competitive pricing and excellent customer service. Contact us for a free quote today!</p>',
                'blog_category_id' => $travelCategory->id,
                'user_id' => $admin->id,
                'status' => 'published',
                'published_at' => now()->subDays(8),
                'is_featured' => false,
                'tags' => ['Delhi', 'Mumbai', 'route guide', 'transportation'],
                'reading_time' => '6 min read',
                'meta_title' => 'Delhi to Mumbai Vehicle Transport Route Guide',
                'meta_description' => 'Complete guide for Delhi to Mumbai vehicle transportation including routes, costs, timeline, and booking tips.',
            ],

            // Customer Story
            [
                'title' => 'Customer Success Story: Safe BMW Transport from Bangalore to Delhi',
                'slug' => 'customer-story-bmw-transport-bangalore-delhi',
                'excerpt' => 'Read how we successfully transported a luxury BMW from Bangalore to Delhi with zero damage and excellent service.',
                'content' => '<h2>The Challenge</h2>

<p>Mr. Rajesh Kumar, a software engineer from Bangalore, needed to transport his brand new BMW 320d to Delhi for his job relocation. Being a luxury vehicle worth over ₹40 lakhs, he was naturally concerned about the safety and security of his car during the long-distance transport.</p>

<h2>Why He Chose BN Car Transport</h2>

<p>After researching multiple vehicle transportation companies, Mr. Kumar chose BN Car Transport for several reasons:</p>

<ul>
<li>Specialized enclosed transport for luxury vehicles</li>
<li>Comprehensive insurance coverage</li>
<li>Excellent customer reviews and ratings</li>
<li>Transparent pricing with no hidden charges</li>
<li>Professional customer service team</li>
</ul>

<h2>The Service Experience</h2>

<h3>Pre-Transport Preparation</h3>
<p>Our team conducted a thorough inspection of the BMW, documenting its pristine condition with detailed photographs from multiple angles. We provided Mr. Kumar with a comprehensive checklist to prepare his vehicle for transport.</p>

<h3>Secure Loading Process</h3>
<p>The BMW was carefully loaded onto our enclosed carrier using specialized equipment designed for luxury vehicles. Our experienced drivers ensured the car was properly secured with soft straps to prevent any scratches or damage.</p>

<h3>Real-Time Tracking</h3>
<p>Throughout the 2,200-kilometer journey from Bangalore to Delhi, Mr. Kumar received regular updates about his vehicle\'s location and status through our GPS tracking system and customer service team.</p>

<h2>Safe Delivery</h2>

<p>The BMW arrived in Delhi exactly as scheduled, in perfect condition. Our delivery team conducted another thorough inspection with Mr. Kumar, confirming that the vehicle had been transported without any damage whatsoever.</p>

<h2>Customer Feedback</h2>

<blockquote>
<p>"I was initially nervous about transporting my new BMW such a long distance, but BN Car Transport exceeded all my expectations. The entire process was professional, transparent, and stress-free. My car arrived in perfect condition, and the team kept me informed throughout the journey. I would definitely recommend their services to anyone needing vehicle transportation."</p>
<footer>— Rajesh Kumar, Software Engineer, Delhi</footer>
</blockquote>

<h2>Key Success Factors</h2>

<ul>
<li><strong>Specialized Equipment:</strong> Enclosed carrier specifically designed for luxury vehicles</li>
<li><strong>Professional Team:</strong> Experienced drivers and handling staff</li>
<li><strong>Clear Communication:</strong> Regular updates throughout the transport process</li>
<li><strong>Comprehensive Insurance:</strong> Full coverage for peace of mind</li>
<li><strong>Attention to Detail:</strong> Thorough documentation and careful handling</li>
</ul>

<h2>The Results</h2>

<ul>
<li>Zero damage to the vehicle</li>
<li>On-time delivery as promised</li>
<li>100% customer satisfaction</li>
<li>Stress-free experience for the customer</li>
<li>Strong customer relationship built for future services</li>
</ul>

<h2>What This Means for You</h2>

<p>This success story demonstrates our commitment to providing exceptional vehicle transportation services, especially for luxury and high-value vehicles. Whether you\'re relocating for work, purchasing a vehicle from another city, or need any other vehicle transportation service, you can trust BN Car Transport to handle your vehicle with the utmost care and professionalism.</p>

<p>Contact us today to discuss your vehicle transportation needs and experience the same level of service that made Mr. Kumar a satisfied customer.</p>',
                'blog_category_id' => $storiesCategory->id,
                'user_id' => $admin->id,
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'is_featured' => true,
                'tags' => ['customer story', 'BMW', 'luxury transport', 'success'],
                'reading_time' => '4 min read',
                'meta_title' => 'BMW Transport Success Story - Bangalore to Delhi',
                'meta_description' => 'Read how BN Car Transport successfully transported a luxury BMW from Bangalore to Delhi with zero damage and excellent service.',
            ],
        ];

        foreach ($posts as $postData) {
            BlogPost::create($postData);
        }

        // Create a few more posts with different statuses
        $additionalPosts = [
            [
                'title' => '10 Essential Car Maintenance Tips Before Long-Distance Transport',
                'slug' => 'car-maintenance-tips-before-transport',
                'excerpt' => 'Prepare your car for transportation with these essential maintenance tips to ensure a smooth shipping experience.',
                'content' => '<p>Proper car maintenance before transportation is crucial...</p>',
                'blog_category_id' => $carTipsCategory->id,
                'user_id' => $admin->id,
                'status' => 'draft',
                'tags' => ['maintenance', 'preparation', 'tips'],
                'reading_time' => '3 min read',
            ],
            [
                'title' => 'New Electric Vehicle Transport Services Coming Soon',
                'slug' => 'electric-vehicle-transport-services',
                'excerpt' => 'We\'re excited to announce our upcoming specialized services for electric vehicle transportation.',
                'content' => '<p>Electric vehicles require special handling...</p>',
                'blog_category_id' => $newsCategory->id,
                'user_id' => $admin->id,
                'status' => 'scheduled',
                'published_at' => now()->addDays(7),
                'tags' => ['electric vehicles', 'announcement', 'services'],
                'reading_time' => '2 min read',
            ],
        ];

        foreach ($additionalPosts as $postData) {
            BlogPost::create($postData);
        }
    }
}