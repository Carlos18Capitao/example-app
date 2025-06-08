<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Casaco;
use Illuminate\Support\Facades\DB;

class CasacoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Casaco::factory(10)->create([
            'pessoa_id' => \App\Models\Pessoa::factory(),
        ]); */
        DB::table('casacos')->insert([
            'cor' => 'Preto',
            'quantidade' => 3,
            'pessoa_id' => \App\Models\Pessoa::factory()->create()->id,
        ]);
    }
}
