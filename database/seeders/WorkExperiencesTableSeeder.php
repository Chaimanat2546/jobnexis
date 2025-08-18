<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WorkExperiencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('work_experiences')->insert([
            [
                'we_id' => 'sample',
                'we_company_name' => 'WeCompanyName Sample',
                'we_position' => 'sample',
                'we_start_date' => '2025-01-01',
                'we_end_date' => '2025-01-01',
                'we_amount' => 1,
                'we_u_duties' => 'sample',
                'we_u_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'we_id' => 'sample',
                'we_company_name' => 'WeCompanyName Sample',
                'we_position' => 'sample',
                'we_start_date' => '2025-01-01',
                'we_end_date' => '2025-01-01',
                'we_amount' => 1,
                'we_u_duties' => 'sample',
                'we_u_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'we_id' => 'sample',
                'we_company_name' => 'WeCompanyName Sample',
                'we_position' => 'sample',
                'we_start_date' => '2025-01-01',
                'we_end_date' => '2025-01-01',
                'we_amount' => 1,
                'we_u_duties' => 'sample',
                'we_u_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'we_id' => 'sample',
                'we_company_name' => 'WeCompanyName Sample',
                'we_position' => 'sample',
                'we_start_date' => '2025-01-01',
                'we_end_date' => '2025-01-01',
                'we_amount' => 1,
                'we_u_duties' => 'sample',
                'we_u_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'we_id' => 'sample',
                'we_company_name' => 'WeCompanyName Sample',
                'we_position' => 'sample',
                'we_start_date' => '2025-01-01',
                'we_end_date' => '2025-01-01',
                'we_amount' => 1,
                'we_u_duties' => 'sample',
                'we_u_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
