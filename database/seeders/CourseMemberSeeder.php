<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseMember;
use App\Models\Course;
use App\Models\User;

class CourseMemberSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::first();
        $user = User::first();
        CourseMember::create([
            'cm_c_id' => $course?->c_id,
            'cm_u_id' => $user?->id,
            'cm_passed' => false,
        ]);
    }
}
