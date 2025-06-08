<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fato>
 */
class FatoFactory extends Factory
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
            'quantidade' => $this->faker->numberBetween(1, 10),
            'casaco_id' => \App\Models\Casaco::factory(),
            'calca_id' => \App\Models\Calca::factory(),
        ];
    }
}
