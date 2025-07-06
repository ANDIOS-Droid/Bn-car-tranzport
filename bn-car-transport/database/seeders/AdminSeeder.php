<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@bncartransport.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@bncarransport.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create default settings
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'BN Car Transport', 'type' => 'text', 'group' => 'general', 'label' => 'Site Name'],
            ['key' => 'site_description', 'value' => 'Professional car and bike transportation services across India', 'type' => 'textarea', 'group' => 'general', 'label' => 'Site Description'],
            ['key' => 'site_logo', 'value' => '', 'type' => 'image', 'group' => 'general', 'label' => 'Site Logo'],
            ['key' => 'favicon', 'value' => '', 'type' => 'image', 'group' => 'general', 'label' => 'Favicon'],
            
            // Contact Settings
            ['key' => 'contact_phone', 'value' => '+91 9876543210', 'type' => 'text', 'group' => 'contact', 'label' => 'Phone Number'],
            ['key' => 'contact_email', 'value' => 'info@bncarransport.com', 'type' => 'email', 'group' => 'contact', 'label' => 'Email Address'],
            ['key' => 'contact_address', 'value' => '123 Transport Street, Delhi, India', 'type' => 'textarea', 'group' => 'contact', 'label' => 'Address'],
            ['key' => 'business_hours', 'value' => 'Mon-Sat: 9:00 AM - 7:00 PM', 'type' => 'text', 'group' => 'contact', 'label' => 'Business Hours'],
            
            // Social Media
            ['key' => 'facebook_url', 'value' => '', 'type' => 'url', 'group' => 'social', 'label' => 'Facebook URL'],
            ['key' => 'twitter_url', 'value' => '', 'type' => 'url', 'group' => 'social', 'label' => 'Twitter URL'],
            ['key' => 'instagram_url', 'value' => '', 'type' => 'url', 'group' => 'social', 'label' => 'Instagram URL'],
            ['key' => 'linkedin_url', 'value' => '', 'type' => 'url', 'group' => 'social', 'label' => 'LinkedIn URL'],
            
            // SEO Settings
            ['key' => 'meta_title', 'value' => 'BN Car Transport - Professional Vehicle Transportation Services', 'type' => 'text', 'group' => 'seo', 'label' => 'Meta Title'],
            ['key' => 'meta_description', 'value' => 'Reliable car and bike transportation services across major Indian cities. Safe, fast, and affordable vehicle transport solutions.', 'type' => 'textarea', 'group' => 'seo', 'label' => 'Meta Description'],
            ['key' => 'meta_keywords', 'value' => 'car transport, bike transport, vehicle transportation, India, logistics', 'type' => 'text', 'group' => 'seo', 'label' => 'Meta Keywords'],
            
            // Email Settings
            ['key' => 'admin_email', 'value' => 'admin@bncarransport.com', 'type' => 'email', 'group' => 'email', 'label' => 'Admin Email'],
            ['key' => 'quote_notification_email', 'value' => 'quotes@bncarransport.com', 'type' => 'email', 'group' => 'email', 'label' => 'Quote Notification Email'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                array_merge($setting, [
                    'is_editable' => true,
                    'sort_order' => 0,
                ])
            );
        }

        $this->command->info('Admin user and default settings created successfully!');
        $this->command->info('Admin Login: admin@bncarransport.com');
        $this->command->info('Admin Password: password123');
    }
}
