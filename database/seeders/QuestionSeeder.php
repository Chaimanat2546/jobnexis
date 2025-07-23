<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Exam;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $exam = Exam::first();
        Question::create([
            'q_question' => 'What is Laravel?',
            'q_answer1' => 'A PHP framework',
            'q_answer2' => 'A JavaScript library',
            'q_answer3' => 'A CSS framework',
            'q_answer4' => 'A database',
            'q_correct_answer' => 1,
            'q_e_id' => $exam?->e_id,
        ]);
    }
}
