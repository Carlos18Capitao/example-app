<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Calca;
use App\Models\Casaco;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'encomenda_id' => \App\Models\Encomenda::factory(),
            'itemable_type' => $this->faker->randomElement([Casaco::class, Calca::class]), // Exemplo de modelos polimórficos
            'itemable_id' => \App\Models\Casaco::factory(), // Pode ser outro modelo se necessário
            'quantidade' => $this->faker->numberBetween(1, 10), // Quantidade entre 1 e 10
        ];
    }   
}
