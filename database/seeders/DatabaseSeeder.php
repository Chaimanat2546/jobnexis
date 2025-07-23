<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CompaniesProfileSeeder::class,
            UserProfileSeeder::class,
            EducationSeeder::class,
            WorkExperienceSeeder::class,
            CourseSeeder::class,
            CourseMemberSeeder::class,
            CertificateSeeder::class,
            LessonSeeder::class,
            ExamSeeder::class,
            QuestionSeeder::class,
            RecruitmentSeeder::class,
        ]);
    }
}
