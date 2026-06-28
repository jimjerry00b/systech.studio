<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Donald V2',
            'email' => 'donald@example.com',
            'password' => bcrypt('123456'),
            'is_deletable' => 0,
            'role_id' => 1,
        ]);
        
        $this->call([
            ServiceSeeder::class,
            ProjectSeeder::class,
            TeamMemberSeeder::class,
        ]);
    }
}
