<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recruitment;
use App\Models\CompaniesProfile;
use App\Models\User;

class RecruitmentSeeder extends Seeder
{
    public function run(): void
    {
        $company = CompaniesProfile::first();
        $user = User::where('role', 'provider')->first();
        Recruitment::create([
            'rc_title' => 'PHP Developer',
            'rc_description' => 'Develop and maintain web applications.',
            'rc_requirements' => 'Laravel, MySQL',
            'rc_salary' => '30000',
            'rc_location_link' => 'https://maps.google.com',
            'rc_type' => 'full-time',
            'rc_status' => 'open',
            'rc_posted_at' => now(),
            'rc_expire_at' => now()->addMonth(),
            'rc_co_id' => $company?->co_id,
            'rc_user_id' => $user?->id,
        ]);
    }
}
