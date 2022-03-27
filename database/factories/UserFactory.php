<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name'   => $this->faker->firstName(),
            'last_name'    => $this->faker->lastName(),
            'email'        => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->e164PhoneNumber(),
        ];
    }

    public function agent(): UserFactory
    {
        return $this->state([
            'role' => User::ROLE_AGENT,
        ]);
    }

    public function client(): UserFactory
    {
        return $this->state([
            'role' => User::ROLE_CLIENT,
        ]);
    }
}
