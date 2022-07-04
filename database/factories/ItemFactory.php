<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['name' => "string", 'description' => "string", 'completed' => "bool"])]
    public function definition(): array
    {
        return [
            'name' => $this->faker->jobTitle,
            'description' => $this->faker->realText,
            'completed' => $this->faker->boolean,
        ];
    }
}
