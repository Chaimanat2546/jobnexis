<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Lesson;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        $lesson = Lesson::first();
        Exam::create([
            'e_name' => 'Laravel Basics',
            'e_description' => 'Test your Laravel knowledge',
            'e_l_id' => $lesson?->l_id,
        ]);
    }
}
