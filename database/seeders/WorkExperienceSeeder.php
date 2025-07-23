<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkExperiences;
use App\Models\User;

class WorkExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        WorkExperiences::create([
            'we_company_name' => 'Acme Corp',
            'we_position' => 'Developer',
            'we_start_date' => '2013-01-01',
            'we_end_date' => '2018-01-01',
            'we_amount' => 5,
            'we_u_duties' => 'Develop web applications',
            'we_u_id' => $user?->id,
        ]);
    }
}
