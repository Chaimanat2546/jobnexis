<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Course;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::first();
        Lesson::create([
            'l_name' => 'Introduction',
            'l_description' => 'Intro to Laravel',
            'l_status' => 'open',
            'l_index' => '1',
            'l_c_id' => $course?->c_id,
        ]);
    }
}
