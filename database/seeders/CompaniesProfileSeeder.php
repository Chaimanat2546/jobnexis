<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompaniesProfile;
use App\Models\User;

class CompaniesProfileSeeder extends Seeder
{
    public function run(): void
    {
        $provider = User::where('role', 'provider')->first();
        CompaniesProfile::create([
            'co_name' => 'Acme Corp',
            'co_logo' => 'https://acme.com',
            'co_tagline' => 'We build things',
            'co_description' => 'Acme is a leading company.',
            'co_website' => 'https://acme.com',
            'co_email' => 'contact@acme.com',
            'co_phone' => '0123456789',
            'co_address' => '123 Main St',
            'co_city' => 'Bangkok',
            'co_country' => 'Thailand',
            'co_founded_at' => '2000-01-01',
            'co_user_id' => $provider?->{$provider->getKeyName()},
        ]);
    }
}
