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
        $this->call([
            RoleSeeder::class,
            DistrictSeeder::class,
            CategorySeeder::class,
        ]);

        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@safenix.com',
        ]);
        $admin->assignRole('admin');

        // Create test user
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $user->assignRole('user');
    }
}
