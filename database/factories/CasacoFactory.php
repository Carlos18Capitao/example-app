<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Casaco>
 */
class CasacoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cor' => $this->faker->colorName(),
            'quantidade' => $this->faker->numberBetween(1, 10), // Quantidade entre 1 e 10
        ];
    }
}
