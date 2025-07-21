<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserProfile;
use App\Models\User;

class UserProfileSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        UserProfile::create([
            'up_prefix' => 'Mr.',
            'up_first_name' => 'John',
            'up_last_name' => 'Doe',
            'up_address' => '123 Main St',
            'up_city' => 'Bangkok',
            'up_country' => 'Thailand',
            'up_birth_date' => '1990-01-01',
            'up_gender' => 'male',
            'up_nationality' => 'Thai',
            'up_phone' => '0812345678',
            'up_u_id' => $user?->id,
        ]);
    }
}
