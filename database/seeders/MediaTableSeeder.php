<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('media')->insert([
            [
                'm_id' => 'sample',
                'm_name' => 'MName Sample',
                'm_index' => 1,
                'm_path' => 'sample',
                'm_l_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'm_id' => 'sample',
                'm_name' => 'MName Sample',
                'm_index' => 1,
                'm_path' => 'sample',
                'm_l_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'm_id' => 'sample',
                'm_name' => 'MName Sample',
                'm_index' => 1,
                'm_path' => 'sample',
                'm_l_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'm_id' => 'sample',
                'm_name' => 'MName Sample',
                'm_index' => 1,
                'm_path' => 'sample',
                'm_l_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'm_id' => 'sample',
                'm_name' => 'MName Sample',
                'm_index' => 1,
                'm_path' => 'sample',
                'm_l_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
