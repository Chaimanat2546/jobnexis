<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasswordResetTokensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('password_reset_tokens')->insert([
            [
                'email' => 'email@example.com',
                'token' => 'sample',
                'created_at' => now(),
            ],
            [
                'email' => 'email@example.com',
                'token' => 'sample',
                'created_at' => now(),
            ],
            [
                'email' => 'email@example.com',
                'token' => 'sample',
                'created_at' => now(),
            ],
            [
                'email' => 'email@example.com',
                'token' => 'sample',
                'created_at' => now(),
            ],
            [
                'email' => 'email@example.com',
                'token' => 'sample',
                'created_at' => now(),
            ]
        ]);
    }
}
