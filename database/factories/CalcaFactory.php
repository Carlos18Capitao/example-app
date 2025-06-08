<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Calca>
 */
class CalcaFactory extends Factory
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
            'tamanho' => $this->faker->randomElement(['P', 'M', 'G', 'GG']),
        ];
    }
}
