<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'email' => 'email2@example.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$exampleexampleexampleexampleexamplee',
                'role' => 'jobber',
                'is_banned' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'email1@example.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$exampleexampleexampleexampleexamplee',
                'role' => 'jobber',
                'is_banned' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'email12@example.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$exampleexampleexampleexampleexamplee',
                'role' => 'jobber',
                'is_banned' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'email123@example.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$exampleexampleexampleexampleexamplee',
                'role' => 'jobber',
                'is_banned' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'email234@example.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$exampleexampleexampleexampleexamplee',
                'role' => 'jobber',
                'is_banned' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
