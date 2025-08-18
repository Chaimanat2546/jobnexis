<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseMembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('course_members')->insert([
            [
                'cm_id' => 'sample',
                'cm_c_id' => 1,
                'cm_u_id' => 1,
                'cm_passed' => '$2y$10$exampleexampleexampleexampleexamplee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cm_id' => 'sample',
                'cm_c_id' => 1,
                'cm_u_id' => 1,
                'cm_passed' => '$2y$10$exampleexampleexampleexampleexamplee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cm_id' => 'sample',
                'cm_c_id' => 1,
                'cm_u_id' => 1,
                'cm_passed' => '$2y$10$exampleexampleexampleexampleexamplee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cm_id' => 'sample',
                'cm_c_id' => 1,
                'cm_u_id' => 1,
                'cm_passed' => '$2y$10$exampleexampleexampleexampleexamplee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cm_id' => 'sample',
                'cm_c_id' => 1,
                'cm_u_id' => 1,
                'cm_passed' => '$2y$10$exampleexampleexampleexampleexamplee',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
