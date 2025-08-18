<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_profiles')->insert([
            [
                'up_id' => 'sample',
                'up_prefix' => 'sample',
                'up_first_name' => 'UpFirstName Sample',
                'up_last_name' => 'UpLastName Sample',
                'up_address' => '123 Main St',
                'up_city' => 'Bangkok',
                'up_country' => 'TH',
                'up_birth_date' => '2025-01-01',
                'up_gender' => 'sample',
                'up_nationality' => 'sample',
                'up_phone' => '0900000000',
                'up_u_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'up_id' => 'sample',
                'up_prefix' => 'sample',
                'up_first_name' => 'UpFirstName Sample',
                'up_last_name' => 'UpLastName Sample',
                'up_address' => '123 Main St',
                'up_city' => 'Bangkok',
                'up_country' => 'TH',
                'up_birth_date' => '2025-01-01',
                'up_gender' => 'sample',
                'up_nationality' => 'sample',
                'up_phone' => '0900000000',
                'up_u_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'up_id' => 'sample',
                'up_prefix' => 'sample',
                'up_first_name' => 'UpFirstName Sample',
                'up_last_name' => 'UpLastName Sample',
                'up_address' => '123 Main St',
                'up_city' => 'Bangkok',
                'up_country' => 'TH',
                'up_birth_date' => '2025-01-01',
                'up_gender' => 'sample',
                'up_nationality' => 'sample',
                'up_phone' => '0900000000',
                'up_u_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'up_id' => 'sample',
                'up_prefix' => 'sample',
                'up_first_name' => 'UpFirstName Sample',
                'up_last_name' => 'UpLastName Sample',
                'up_address' => '123 Main St',
                'up_city' => 'Bangkok',
                'up_country' => 'TH',
                'up_birth_date' => '2025-01-01',
                'up_gender' => 'sample',
                'up_nationality' => 'sample',
                'up_phone' => '0900000000',
                'up_u_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'up_id' => 'sample',
                'up_prefix' => 'sample',
                'up_first_name' => 'UpFirstName Sample',
                'up_last_name' => 'UpLastName Sample',
                'up_address' => '123 Main St',
                'up_city' => 'Bangkok',
                'up_country' => 'TH',
                'up_birth_date' => '2025-01-01',
                'up_gender' => 'sample',
                'up_nationality' => 'sample',
                'up_phone' => '0900000000',
                'up_u_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
