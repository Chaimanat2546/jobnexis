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
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Education User',
            'email' => 'education@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'education',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Provider User',
            'email' => 'provider user',
            'password' => Hash::make('password'),
            'role' => 'provider',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Jobber User',
            'email' => 'jobber@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'jobber',
            'email_verified_at' => now(),
        ]);
    }
}
