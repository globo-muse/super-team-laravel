<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'responder_id' => User::factory()->create()->id,
            'name' => fake()->firstName(),
            'email' => fake()->safeEmail(),
            'occasion' => fake()->word(),
            'instructions' => fake()->text(),
            'status' => 'open',
        ];
    }
}
