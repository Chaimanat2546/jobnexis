<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobBatchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('job_batches')->insert([
            [
                'id' => 'sample',
                'name' => 'Name Sample',
                'total_jobs' => 1,
                'pending_jobs' => 1,
                'failed_jobs' => 1,
                'failed_job_ids' => 'sample',
                'options' => 'sample',
                'cancelled_at' => 1,
                'created_at' => now(),
                'finished_at' => 1
            ],
            [
                'id' => 'sample',
                'name' => 'Name Sample',
                'total_jobs' => 1,
                'pending_jobs' => 1,
                'failed_jobs' => 1,
                'failed_job_ids' => 'sample',
                'options' => 'sample',
                'cancelled_at' => 1,
                'created_at' => now(),
                'finished_at' => 1
            ],
            [
                'id' => 'sample',
                'name' => 'Name Sample',
                'total_jobs' => 1,
                'pending_jobs' => 1,
                'failed_jobs' => 1,
                'failed_job_ids' => 'sample',
                'options' => 'sample',
                'cancelled_at' => 1,
                'created_at' => now(),
                'finished_at' => 1
            ],
            [
                'id' => 'sample',
                'name' => 'Name Sample',
                'total_jobs' => 1,
                'pending_jobs' => 1,
                'failed_jobs' => 1,
                'failed_job_ids' => 'sample',
                'options' => 'sample',
                'cancelled_at' => 1,
                'created_at' => now(),
                'finished_at' => 1
            ],
            [
                'id' => 'sample',
                'name' => 'Name Sample',
                'total_jobs' => 1,
                'pending_jobs' => 1,
                'failed_jobs' => 1,
                'failed_job_ids' => 'sample',
                'options' => 'sample',
                'cancelled_at' => 1,
                'created_at' => now(),
                'finished_at' => 1
            ]
        ]);
    }
}
