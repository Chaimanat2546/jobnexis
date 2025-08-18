<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EducationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('educations')->insert([
            [
                'ed_id' => 'sample',
                'ed_name' => 'EdName Sample',
                'ed_start_date' => '2025-01-01',
                'ed_end_date' => '2025-01-01',
                'ed_degree' => 'sample',
                'ed_u_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ed_id' => 'sample',
                'ed_name' => 'EdName Sample',
                'ed_start_date' => '2025-01-01',
                'ed_end_date' => '2025-01-01',
                'ed_degree' => 'sample',
                'ed_u_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ed_id' => 'sample',
                'ed_name' => 'EdName Sample',
                'ed_start_date' => '2025-01-01',
                'ed_end_date' => '2025-01-01',
                'ed_degree' => 'sample',
                'ed_u_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ed_id' => 'sample',
                'ed_name' => 'EdName Sample',
                'ed_start_date' => '2025-01-01',
                'ed_end_date' => '2025-01-01',
                'ed_degree' => 'sample',
                'ed_u_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ed_id' => 'sample',
                'ed_name' => 'EdName Sample',
                'ed_start_date' => '2025-01-01',
                'ed_end_date' => '2025-01-01',
                'ed_degree' => 'sample',
                'ed_u_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
