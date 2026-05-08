<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Web Development',
                'slug' => 'web-development',
                'icon' => 'code',
                'summary' => 'Custom websites and web applications built with modern frameworks.',
                'description' => 'We design and develop high-performance websites and web applications tailored to your business needs. From corporate sites to complex SaaS platforms, our team delivers clean, scalable, and maintainable code that grows with your business.',
                'features' => [
                    'Laravel & PHP backend development',
                    'Vue.js, React & Livewire frontends',
                    'RESTful & GraphQL APIs',
                    'Database design & optimization',
                    'CI/CD pipeline setup',
                ],
                'sort_order' => 1,
            ],
            [
                'title' => 'UI / UX Design',
                'slug' => 'ui-ux-design',
                'icon' => 'palette',
                'summary' => 'User-centered design that turns visitors into customers.',
                'description' => 'Our design team blends aesthetics with usability research to craft interfaces that feel intuitive and delight users. We start with discovery, move through wireframes and prototypes, and deliver pixel-perfect production designs.',
                'features' => [
                    'User research & journey mapping',
                    'Wireframing & interactive prototyping',
                    'Design systems & component libraries',
                    'Accessibility (WCAG 2.1 AA)',
                    'Usability testing',
                ],
                'sort_order' => 2,
            ],
            [
                'title' => 'Mobile Applications',
                'slug' => 'mobile-applications',
                'icon' => 'mobile',
                'summary' => 'Native and cross-platform apps for iOS and Android.',
                'description' => 'Reach your customers wherever they are. We build performant mobile apps using React Native and Flutter, with native modules where the platform demands it. Our apps ship with crash analytics, push notifications, and offline-first architecture.',
                'features' => [
                    'React Native & Flutter',
                    'Native iOS (Swift) & Android (Kotlin)',
                    'App Store & Play Store deployment',
                    'Push notifications & deep linking',
                    'Offline-first sync architecture',
                ],
                'sort_order' => 3,
            ],
            [
                'title' => 'Cloud & DevOps',
                'slug' => 'cloud-devops',
                'icon' => 'cloud',
                'summary' => 'Reliable infrastructure that scales with your business.',
                'description' => 'We architect, deploy, and maintain cloud infrastructure on AWS, Google Cloud, and DigitalOcean. From single-server setups to multi-region high-availability clusters, we handle the operations so you can focus on the product.',
                'features' => [
                    'AWS, GCP & DigitalOcean architecture',
                    'Docker & Kubernetes orchestration',
                    'GitHub Actions & GitLab CI pipelines',
                    'Monitoring with Grafana & Sentry',
                    '24/7 uptime monitoring & on-call',
                ],
                'sort_order' => 4,
            ],
            [
                'title' => 'Branding & Identity',
                'slug' => 'branding-identity',
                'icon' => 'sparkles',
                'summary' => 'Memorable brands that resonate with your audience.',
                'description' => 'A great product needs a brand to match. We craft logos, brand guidelines, and visual identity systems that communicate your values and stand out in your market. Every deliverable is built to scale across digital and print.',
                'features' => [
                    'Logo design & brand marks',
                    'Brand guidelines & style guides',
                    'Typography & color systems',
                    'Print collateral & business cards',
                    'Social media kit',
                ],
                'sort_order' => 5,
            ],
            [
                'title' => 'SEO & Marketing',
                'slug' => 'seo-marketing',
                'icon' => 'chart',
                'summary' => 'Get found, get traffic, get customers.',
                'description' => 'Build a website is only step one. We help you grow through technical SEO audits, content strategy, and conversion-rate optimization. Our team uses real data to make decisions that move the needle.',
                'features' => [
                    'Technical SEO audits',
                    'On-page & off-page optimization',
                    'Content strategy & copywriting',
                    'Google Analytics 4 & Search Console',
                    'Conversion rate optimization (CRO)',
                ],
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }
}
