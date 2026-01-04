<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question' => fake()->sentence(),
            'answer' => fake()->text(),
        ];
    }

    public function forRandomUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => User::factory(),
        ]);
    }

    public function requiresHuman(): static
    {
        return $this->state(fn (array $attributes) => [
            'requires_human' => true,
        ]);
    }

    public function unanswered(): static
    {
        return $this->state(fn (array $attributes) => [
            'answer' => null,
        ]);
    }
}
