<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Calca;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Calca::factory(10)->create([
            'pessoa_id' => \App\Models\Pessoa::factory(),
        ]); */
        DB::table('calcas')->insert([
            'cor' => 'Azul',
            'quantidade' => 4,
            'pessoa_id' => \App\Models\Pessoa::factory()->create()->id,
        ]);
    }
}
