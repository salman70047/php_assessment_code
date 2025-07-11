<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('Admin123!'),
            'phone' => '+1234567890',
            'bio' => 'System Administrator',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create regular test user
        User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('User123!'),
            'phone' => '+0987654321',
            'bio' => 'Regular user for testing',
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin and test users created successfully!');
        $this->command->info('Admin: admin@example.com / Admin123!');
        $this->command->info('User: user@example.com / User123!');
    }
}

