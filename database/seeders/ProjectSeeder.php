<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Northwind E-Commerce Platform',
                'slug' => 'northwind-ecommerce',
                'client' => 'Northwind Trading Co.',
                'category' => 'E-Commerce',
                'cover_image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Multi-vendor marketplace with real-time inventory and same-day delivery integration.',
                'description' => 'Northwind needed to migrate from a legacy system to a modern multi-vendor platform supporting thousands of SKUs and dozens of regional warehouses. We delivered a Laravel + Vue.js stack with Redis-backed search, Stripe Connect for vendor payouts, and a logistics integration with three regional carriers. The platform processes over 5,000 orders per day with sub-200ms response times.',
                'technologies' => ['Laravel 12', 'Vue.js 3', 'Inertia.js', 'MySQL', 'Redis', 'Stripe Connect'],
                'website_url' => 'https://example.com',
                'completed_at' => '2025-11-15',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Helix Healthcare Portal',
                'slug' => 'helix-healthcare-portal',
                'client' => 'Helix Medical Group',
                'category' => 'Healthcare',
                'cover_image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'HIPAA-compliant patient portal with telehealth and prescription management.',
                'description' => 'A secure patient-facing portal handling appointment booking, prescription refills, lab results, and HIPAA-compliant video consultations. Built with strict audit logging, role-based access control, and end-to-end encryption for all PHI. Successfully passed third-party security audit on first submission.',
                'technologies' => ['Laravel 11', 'Livewire', 'Twilio Video', 'PostgreSQL', 'AWS KMS'],
                'website_url' => null,
                'completed_at' => '2025-09-22',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Apex Analytics Dashboard',
                'slug' => 'apex-analytics-dashboard',
                'client' => 'Apex Capital Partners',
                'category' => 'SaaS',
                'cover_image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Real-time financial analytics platform processing 50M events per day.',
                'description' => 'A high-performance analytics dashboard surfacing trading insights for institutional investors. Backend powered by Laravel Octane and ClickHouse for time-series data, with WebSocket streams pushing live updates to a React frontend. Sub-second query response on terabyte-scale datasets.',
                'technologies' => ['Laravel Octane', 'React', 'ClickHouse', 'Redis', 'WebSockets'],
                'website_url' => 'https://example.com',
                'completed_at' => '2025-07-30',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Greenfield Property Listings',
                'slug' => 'greenfield-property-listings',
                'client' => 'Greenfield Realty',
                'category' => 'Real Estate',
                'cover_image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Modern property portal with map-based search and virtual tours.',
                'description' => 'A property listing platform integrating MLS feeds, Mapbox-powered search, and 360° virtual tours. Includes a CRM for agents, lead capture forms, and automated email drip campaigns. SEO-optimized listings rank on the first page for over 2,000 local search terms.',
                'technologies' => ['Laravel 11', 'Alpine.js', 'Mapbox GL', 'MySQL', 'Meilisearch'],
                'website_url' => 'https://example.com',
                'completed_at' => '2025-05-10',
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'title' => 'Lumen Learning Platform',
                'slug' => 'lumen-learning-platform',
                'client' => 'Lumen Education',
                'category' => 'EdTech',
                'cover_image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Online course platform with video streaming, quizzes, and certificates.',
                'description' => 'A complete LMS supporting self-paced and cohort-based courses. Includes a custom video player with adaptive bitrate streaming, auto-graded quizzes, peer review assignments, and verifiable PDF certificates. Currently serving 40,000 active learners across three continents.',
                'technologies' => ['Laravel 11', 'Vue.js', 'Mux Video', 'PostgreSQL', 'AWS S3'],
                'website_url' => 'https://example.com',
                'completed_at' => '2025-03-18',
                'is_featured' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Forge Restaurant Booking',
                'slug' => 'forge-restaurant-booking',
                'client' => 'Forge Hospitality Group',
                'category' => 'Hospitality',
                'cover_image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Reservation system across 12 restaurants with table-level inventory.',
                'description' => 'A unified reservation platform managing table availability, deposits, dietary preferences, and guest history across 12 restaurant brands. SMS reminders cut no-shows by 38%, and the integrated waitlist increased seat utilization to 94%.',
                'technologies' => ['Laravel 12', 'Livewire', 'MySQL', 'Twilio SMS', 'Stripe'],
                'website_url' => 'https://example.com',
                'completed_at' => '2025-01-25',
                'is_featured' => false,
                'sort_order' => 6,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(['slug' => $project['slug']], $project);
        }
    }
}
