<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'Daniel Reyes',
                'role' => 'Founder & CEO',
                'bio' => 'Daniel founded Systech Studio in 2015 after a decade leading engineering teams at fintech startups. He still writes code on Fridays.',
                'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=600&q=80',
                'linkedin_url' => 'https://linkedin.com/',
                'sort_order' => 1,
            ],
            [
                'name' => 'Mei Tanaka',
                'role' => 'Head of Design',
                'bio' => 'Mei leads our design practice with 12+ years of experience designing for global brands. She is an outspoken advocate for accessible design.',
                'photo' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=600&q=80',
                'linkedin_url' => 'https://linkedin.com/',
                'sort_order' => 2,
            ],
            [
                'name' => 'Samuel Okafor',
                'role' => 'Lead Engineer',
                'bio' => 'Samuel is our resident Laravel expert and infrastructure architect. He has scaled systems handling billions of requests per month.',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80',
                'linkedin_url' => 'https://linkedin.com/',
                'sort_order' => 3,
            ],
            [
                'name' => 'Priya Shah',
                'role' => 'Mobile Tech Lead',
                'bio' => 'Priya specializes in cross-platform mobile development. Her apps have shipped to over 4 million users across iOS and Android.',
                'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=600&q=80',
                'linkedin_url' => 'https://linkedin.com/',
                'sort_order' => 4,
            ],
        ];

        foreach ($members as $member) {
            TeamMember::updateOrCreate(['name' => $member['name']], $member);
        }
    }
}
