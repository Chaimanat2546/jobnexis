<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jobs')->insert([
            [
                'queue' => 'sample',
                'payload' => 'sample',
                'attempts' => 'sample',
                'reserved_at' => 'sample',
                'available_at' => 'sample',
                'created_at' => now(),
            ],
            [
                'queue' => 'sample',
                'payload' => 'sample',
                'attempts' => 'sample',
                'reserved_at' => 'sample',
                'available_at' => 'sample',
                'created_at' => now(),
            ],
            [
                'queue' => 'sample',
                'payload' => 'sample',
                'attempts' => 'sample',
                'reserved_at' => 'sample',
                'available_at' => 'sample',
                'created_at' => now(),
            ],
            [
                'queue' => 'sample',
                'payload' => 'sample',
                'attempts' => 'sample',
                'reserved_at' => 'sample',
                'available_at' => 'sample',
                'created_at' => now(),
            ],
            [
                'queue' => 'sample',
                'payload' => 'sample',
                'attempts' => 'sample',
                'reserved_at' => 'sample',
                'available_at' => 'sample',
                'created_at' => now(),
            ]
        ]);
    }
}
