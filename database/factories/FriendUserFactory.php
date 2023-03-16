<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FriendUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // need to learn how to use faker
        return [
            "user_id" => $this->faker->numberBetween(1, 10),
            "friend_id" => $this->faker->numberBetween(1, 10),
        ];
    }
}
