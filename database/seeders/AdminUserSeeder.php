<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        User::create([
            'username' => 'Education',
            'email' => 'education@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'education',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        User::create([
            'username' => 'Provider',
            'email' => 'provider@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'provider',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        User::create([
            'username' => 'Jobber',
            'email' => 'jobber@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'jobber',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),

        ]);
        User::factory(5)
            ->hasUserProfile()
            ->create();
    }
}
