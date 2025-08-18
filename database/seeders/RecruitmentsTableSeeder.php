<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecruitmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('recruitments')->insert([
            [
                'rc_id' => 'sample',
                'rc_title' => 'Sample Title',
                'rc_description' => 'sample',
                'rc_requirements' => 'sample',
                'rc_salary' => 'sample',
                'rc_location_link' => 'sample',
                'rc_type' => 'sample',
                'rc_status' => 'sample',
                'rc_posted_at' => '2025-01-01',
                'rc_expire_at' => '2025-01-01',
                'rc_co_id' => 1,
                'rc_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rc_id' => 'sample',
                'rc_title' => 'Sample Title',
                'rc_description' => 'sample',
                'rc_requirements' => 'sample',
                'rc_salary' => 'sample',
                'rc_location_link' => 'sample',
                'rc_type' => 'sample',
                'rc_status' => 'sample',
                'rc_posted_at' => '2025-01-01',
                'rc_expire_at' => '2025-01-01',
                'rc_co_id' => 1,
                'rc_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rc_id' => 'sample',
                'rc_title' => 'Sample Title',
                'rc_description' => 'sample',
                'rc_requirements' => 'sample',
                'rc_salary' => 'sample',
                'rc_location_link' => 'sample',
                'rc_type' => 'sample',
                'rc_status' => 'sample',
                'rc_posted_at' => '2025-01-01',
                'rc_expire_at' => '2025-01-01',
                'rc_co_id' => 1,
                'rc_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rc_id' => 'sample',
                'rc_title' => 'Sample Title',
                'rc_description' => 'sample',
                'rc_requirements' => 'sample',
                'rc_salary' => 'sample',
                'rc_location_link' => 'sample',
                'rc_type' => 'sample',
                'rc_status' => 'sample',
                'rc_posted_at' => '2025-01-01',
                'rc_expire_at' => '2025-01-01',
                'rc_co_id' => 1,
                'rc_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rc_id' => 'sample',
                'rc_title' => 'Sample Title',
                'rc_description' => 'sample',
                'rc_requirements' => 'sample',
                'rc_salary' => 'sample',
                'rc_location_link' => 'sample',
                'rc_type' => 'sample',
                'rc_status' => 'sample',
                'rc_posted_at' => '2025-01-01',
                'rc_expire_at' => '2025-01-01',
                'rc_co_id' => 1,
                'rc_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
