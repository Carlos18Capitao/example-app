<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* \App\Models\Casa::factory(10)->create([
            'pessoa_id' => \App\Models\Pessoa::factory(),
        ]); */
        DB::table('casas')->insert([
            'cor' => 'Branca',
            'quantidade' => 1,
            'pessoa_id' => \App\Models\Pessoa::factory()->create()->id,
        ]);
    }
}
