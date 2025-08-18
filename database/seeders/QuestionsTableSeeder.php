<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('questions')->insert([
            [
                'q_id' => 'sample',
                'q_question' => 'sample',
                'q_answer1' => 'sample',
                'q_answer2' => 'sample',
                'q_answer3' => 'sample',
                'q_answer4' => 'sample',
                'q_correct_answer' => 1,
                'q_e_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'q_id' => 'sample',
                'q_question' => 'sample',
                'q_answer1' => 'sample',
                'q_answer2' => 'sample',
                'q_answer3' => 'sample',
                'q_answer4' => 'sample',
                'q_correct_answer' => 1,
                'q_e_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'q_id' => 'sample',
                'q_question' => 'sample',
                'q_answer1' => 'sample',
                'q_answer2' => 'sample',
                'q_answer3' => 'sample',
                'q_answer4' => 'sample',
                'q_correct_answer' => 1,
                'q_e_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'q_id' => 'sample',
                'q_question' => 'sample',
                'q_answer1' => 'sample',
                'q_answer2' => 'sample',
                'q_answer3' => 'sample',
                'q_answer4' => 'sample',
                'q_correct_answer' => 1,
                'q_e_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'q_id' => 'sample',
                'q_question' => 'sample',
                'q_answer1' => 'sample',
                'q_answer2' => 'sample',
                'q_answer3' => 'sample',
                'q_answer4' => 'sample',
                'q_correct_answer' => 1,
                'q_e_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
