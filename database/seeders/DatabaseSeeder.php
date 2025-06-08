<?php

namespace Database\Seeders;

use App\Models\Pessoa;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ClienteSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        /* \App\Models\Casa::factory(10)->create([
            'pessoa_id' => \App\Models\Pessoa::factory(),
        ]); */

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */
        $this->call([
            EncomendaSeeder::class,
        ]);
    }
}
