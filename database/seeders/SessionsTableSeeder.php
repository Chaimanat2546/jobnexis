<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sessions')->insert([
            [
                'id' => 'sample',
                'user_id' => 1,
                'ip_address' => '123 Main St',
                'user_agent' => 'sample',
                'payload' => 'sample',
                'last_activity' => 1
            ],
            [
                'id' => 'sample',
                'user_id' => 1,
                'ip_address' => '123 Main St',
                'user_agent' => 'sample',
                'payload' => 'sample',
                'last_activity' => 1
            ],
            [
                'id' => 'sample',
                'user_id' => 1,
                'ip_address' => '123 Main St',
                'user_agent' => 'sample',
                'payload' => 'sample',
                'last_activity' => 1
            ],
            [
                'id' => 'sample',
                'user_id' => 1,
                'ip_address' => '123 Main St',
                'user_agent' => 'sample',
                'payload' => 'sample',
                'last_activity' => 1
            ],
            [
                'id' => 'sample',
                'user_id' => 1,
                'ip_address' => '123 Main St',
                'user_agent' => 'sample',
                'payload' => 'sample',
                'last_activity' => 1
            ]
        ]);
    }
}
