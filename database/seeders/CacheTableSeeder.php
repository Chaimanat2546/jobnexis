<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CacheTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cache')->insert([
            [
                'key' => 'sample',
                'value' => 'sample',
                'expiration' => 1
            ],
            [
                'key' => 'sample',
                'value' => 'sample',
                'expiration' => 1
            ],
            [
                'key' => 'sample',
                'value' => 'sample',
                'expiration' => 1
            ],
            [
                'key' => 'sample',
                'value' => 'sample',
                'expiration' => 1
            ],
            [
                'key' => 'sample',
                'value' => 'sample',
                'expiration' => 1
            ]
        ]);
    }
}
