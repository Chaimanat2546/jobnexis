<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            [
                'c_id' => 'sample',
                'c_name' => 'CName Sample',
                'c_description' => 'sample',
                'c_create_by_id' => 1,
                'c_number' => 'sample',
                'c_create_at' => '2025-01-01',
                'c_end_at' => '2025-01-01',
                'c_status' => 'sample',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'c_id' => 'sample',
                'c_name' => 'CName Sample',
                'c_description' => 'sample',
                'c_create_by_id' => 1,
                'c_number' => 'sample',
                'c_create_at' => '2025-01-01',
                'c_end_at' => '2025-01-01',
                'c_status' => 'sample',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'c_id' => 'sample',
                'c_name' => 'CName Sample',
                'c_description' => 'sample',
                'c_create_by_id' => 1,
                'c_number' => 'sample',
                'c_create_at' => '2025-01-01',
                'c_end_at' => '2025-01-01',
                'c_status' => 'sample',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'c_id' => 'sample',
                'c_name' => 'CName Sample',
                'c_description' => 'sample',
                'c_create_by_id' => 1,
                'c_number' => 'sample',
                'c_create_at' => '2025-01-01',
                'c_end_at' => '2025-01-01',
                'c_status' => 'sample',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'c_id' => 'sample',
                'c_name' => 'CName Sample',
                'c_description' => 'sample',
                'c_create_by_id' => 1,
                'c_number' => 'sample',
                'c_create_at' => '2025-01-01',
                'c_end_at' => '2025-01-01',
                'c_status' => 'sample',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
