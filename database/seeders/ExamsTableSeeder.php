<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('exams')->insert([
            [
                'e_id' => 'sample',
                'e_name' => 'EName Sample',
                'e_description' => 'sample',
                'e_l_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'e_id' => 'sample',
                'e_name' => 'EName Sample',
                'e_description' => 'sample',
                'e_l_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'e_id' => 'sample',
                'e_name' => 'EName Sample',
                'e_description' => 'sample',
                'e_l_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'e_id' => 'sample',
                'e_name' => 'EName Sample',
                'e_description' => 'sample',
                'e_l_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'e_id' => 'sample',
                'e_name' => 'EName Sample',
                'e_description' => 'sample',
                'e_l_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
