<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Casa>
 */
class CasaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'endereco' => $this->faker->address,
            'bairro' => $this->faker->word,
            'cidade' => $this->faker->city,
            'provincia' => $this->faker->word,
            'numero' => $this->faker->numberBetween(1, 100),
            'pessoa_id' => \App\Models\Pessoa::factory(),
        ];
    }
}
