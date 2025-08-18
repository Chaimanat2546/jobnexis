<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CertificatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('certificates')->insert([
            [
                'cer_id' => 'sample',
                'cer_name' => 'CerName Sample',
                'cer_image' => 'sample',
                'cer_u_id' => 'sample',
                'cer_c_id' => 'sample',
                'cer_publiced' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cer_id' => 'sample',
                'cer_name' => 'CerName Sample',
                'cer_image' => 'sample',
                'cer_u_id' => 'sample',
                'cer_c_id' => 'sample',
                'cer_publiced' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cer_id' => 'sample',
                'cer_name' => 'CerName Sample',
                'cer_image' => 'sample',
                'cer_u_id' => 'sample',
                'cer_c_id' => 'sample',
                'cer_publiced' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cer_id' => 'sample',
                'cer_name' => 'CerName Sample',
                'cer_image' => 'sample',
                'cer_u_id' => 'sample',
                'cer_c_id' => 'sample',
                'cer_publiced' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cer_id' => 'sample',
                'cer_name' => 'CerName Sample',
                'cer_image' => 'sample',
                'cer_u_id' => 'sample',
                'cer_c_id' => 'sample',
                'cer_publiced' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
