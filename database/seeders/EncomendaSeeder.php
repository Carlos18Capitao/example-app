<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Encomenda;
use Illuminate\Support\Facades\DB;

class EncomendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cliente::factory()
            ->count(10)
            ->has(
                Encomenda::factory()
                    ->count(1) // ou mais encomendas por cliente
                    ->has(
                        Item::factory()->count(rand(1, 5)) // cada encomenda com 1 a 5 itens
                    )
            )
            ->create();

    }
}
