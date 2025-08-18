<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            CacheTableSeeder::class,
            CertificatesTableSeeder::class,
            CompaniesProfilesTableSeeder::class,
            CourseMembersTableSeeder::class,
            CoursesTableSeeder::class,
            EducationsTableSeeder::class,
            ExamsTableSeeder::class,
            FailedJobsTableSeeder::class,
            JobBatchesTableSeeder::class,
            JobsTableSeeder::class,
            LessonsTableSeeder::class,
            MediaTableSeeder::class,
            PasswordResetTokensTableSeeder::class,
            QuestionsTableSeeder::class,
            RecruitmentsTableSeeder::class,
            SessionsTableSeeder::class,
            UserProfilesTableSeeder::class,
            UsersTableSeeder::class,
            WorkExperiencesTableSeeder::class,
        ]);
    }
}
