<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'up_prefix' => $this->faker->title(),
            'up_first_name' => $this->faker->firstName(),
            'up_last_name' => $this->faker->lastName(),
            'up_address' => $this->faker->address(),
            'up_city' => $this->faker->city(),
            'up_country' => $this->faker->country(),
            'up_birth_date' => $this->faker->date(),
            'up_gender' => $this->faker->randomElement(['male', 'female']),
            'up_nationality' => $this->faker->country(),
            'up_phone' => $this->faker->phoneNumber(),
            'up_u_id' => User::factory(), // ผูกกับ User
        ];
    }
}
