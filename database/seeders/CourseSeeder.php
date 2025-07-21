<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        Course::create([
            'c_name' => 'Laravel Bootcamp',
            'c_description' => 'Learn Laravel from scratch.',
            'c_create_by_id' => $user?->id,
            'c_number' => 'LB2025',
            'c_create_at' => now(),
            'c_end_at' => now()->addMonths(3),
            'c_status' => 'open',
        ]);
    }
}
