<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lessons')->insert([
            [
                'l_id' => 'sample',
                'l_name' => 'LName Sample',
                'l_description' => 'sample',
                'l_status' => 'sample',
                'l_index' => 'sample',
                'l_c_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'l_id' => 'sample',
                'l_name' => 'LName Sample',
                'l_description' => 'sample',
                'l_status' => 'sample',
                'l_index' => 'sample',
                'l_c_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'l_id' => 'sample',
                'l_name' => 'LName Sample',
                'l_description' => 'sample',
                'l_status' => 'sample',
                'l_index' => 'sample',
                'l_c_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'l_id' => 'sample',
                'l_name' => 'LName Sample',
                'l_description' => 'sample',
                'l_status' => 'sample',
                'l_index' => 'sample',
                'l_c_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'l_id' => 'sample',
                'l_name' => 'LName Sample',
                'l_description' => 'sample',
                'l_status' => 'sample',
                'l_index' => 'sample',
                'l_c_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
