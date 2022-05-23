<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {

        $userId = User::inRandomOrder()->first()->id ?? null;

        return !empty($userId) ? [
            'user_id' => $userId,
            'first_name' => $this->faker->firstName,
            'middle_name' => null,
            'last_name' => $this->faker->lastName,
            'phone' => substr($this->faker->e164PhoneNumber, 1),
            'is_favourite' => (boolean)rand(0, 1),
        ] : [];
    }
}
