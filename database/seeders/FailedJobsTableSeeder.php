<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FailedJobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('failed_jobs')->insert([
            [
                'uuid' => 'sample',
                'connection' => 'sample',
                'queue' => 'sample',
                'payload' => 'sample',
                'exception' => 'sample',
                'failed_at' => now(),

            ],
            [
                'uuid' => 'sample',
                'connection' => 'sample',
                'queue' => 'sample',
                'payload' => 'sample',
                'exception' => 'sample',
                'failed_at' => now(),
            ],
            [
                'uuid' => 'sample',
                'connection' => 'sample',
                'queue' => 'sample',
                'payload' => 'sample',
                'exception' => 'sample',
                'failed_at' => now(),
            ],
            [
                'uuid' => 'sample',
                'connection' => 'sample',
                'queue' => 'sample',
                'payload' => 'sample',
                'exception' => 'sample',
                'failed_at' => now(),
            ],
            [
                'uuid' => 'sample',
                'connection' => 'sample',
                'queue' => 'sample',
                'payload' => 'sample',
                'exception' => 'sample',
                'failed_at' => now(),
            ]
        ]);
    }
}
