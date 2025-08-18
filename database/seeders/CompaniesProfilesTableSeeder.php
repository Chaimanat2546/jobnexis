<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompaniesProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies_profiles')->insert([
            [
                'co_id' => 'sample',
                'co_name' => 'CoName Sample',
                'co_logo' => 'sample',
                'co_tagline' => 'sample',
                'co_description' => 'sample',
                'co_website' => 'sample',
                'co_email' => 'co_email@example.com',
                'co_phone' => '0900000000',
                'co_address' => '123 Main St',
                'co_city' => 'Bangkok',
                'co_country' => 'TH',
                'co_founded_at' => '2025-01-01',
                'co_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'co_id' => 'sample',
                'co_name' => 'CoName Sample',
                'co_logo' => 'sample',
                'co_tagline' => 'sample',
                'co_description' => 'sample',
                'co_website' => 'sample',
                'co_email' => 'co_email@example.com',
                'co_phone' => '0900000000',
                'co_address' => '123 Main St',
                'co_city' => 'Bangkok',
                'co_country' => 'TH',
                'co_founded_at' => '2025-01-01',
                'co_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'co_id' => 'sample',
                'co_name' => 'CoName Sample',
                'co_logo' => 'sample',
                'co_tagline' => 'sample',
                'co_description' => 'sample',
                'co_website' => 'sample',
                'co_email' => 'co_email@example.com',
                'co_phone' => '0900000000',
                'co_address' => '123 Main St',
                'co_city' => 'Bangkok',
                'co_country' => 'TH',
                'co_founded_at' => '2025-01-01',
                'co_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'co_id' => 'sample',
                'co_name' => 'CoName Sample',
                'co_logo' => 'sample',
                'co_tagline' => 'sample',
                'co_description' => 'sample',
                'co_website' => 'sample',
                'co_email' => 'co_email@example.com',
                'co_phone' => '0900000000',
                'co_address' => '123 Main St',
                'co_city' => 'Bangkok',
                'co_country' => 'TH',
                'co_founded_at' => '2025-01-01',
                'co_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'co_id' => 'sample',
                'co_name' => 'CoName Sample',
                'co_logo' => 'sample',
                'co_tagline' => 'sample',
                'co_description' => 'sample',
                'co_website' => 'sample',
                'co_email' => 'co_email@example.com',
                'co_phone' => '0900000000',
                'co_address' => '123 Main St',
                'co_city' => 'Bangkok',
                'co_country' => 'TH',
                'co_founded_at' => '2025-01-01',
                'co_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
