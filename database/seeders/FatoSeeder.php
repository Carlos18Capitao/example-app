<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fato;
use Illuminate\Support\Facades\DB;

class FatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Fato::factory(10)->create([
            'pessoa_id' => \App\Models\Pessoa::factory(),
        ]); */
        DB::table('fatos')->insert([
            'cor'=> 'Cinza',
            'quantidade' => 2,
            'casaco_id' => \App\Models\Casaco::factory()->create()->id,
            'calca_id' => \App\Models\Calca::factory()->create()->id,
        ]);
    }
}
