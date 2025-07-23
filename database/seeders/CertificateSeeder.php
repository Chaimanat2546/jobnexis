<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Certificates;
use App\Models\User;
use App\Models\Course;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $course = Course::first();
        Certificates::create([
            'cer_name' => 'Laravel Certificate',
            'cer_image' => 'certificate.png',
            'cer_u_id' => $user?->id,
            'cer_c_id' => $course?->c_id,
            'cer_publiced' => true,
        ]);
    }
}
