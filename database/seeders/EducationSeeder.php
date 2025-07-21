<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Education;
use App\Models\User;

class EducationSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        Education::create([
            'ed_name' => 'Chulalongkorn University',
            'ed_start_date' => '2008-06-01',
            'ed_end_date' => '2012-03-31',
            'ed_degree' => 'Bachelor',
            'ed_u_id' => $user?->id,
        ]);
    }
}
