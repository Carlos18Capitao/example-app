<?php

use App\Services\CasaService;
use App\Services\PessoaService;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

uses(RefreshDatabase::class, WithFaker::class);

test('it can create a casa', function () {
    $casaService = new CasaService();
    $pessoaService = new PessoaService();

    $pessoa = $pessoaService->create([
        'nome' => $this->faker->name,
        'telefone' => $this->faker->phoneNumber,
    ]);

    $data = [
        'endereco' => $this->faker->address,
        'bairro' => $this->faker->word,
        'cidade' => $this->faker->city,
        'provincia' => $this->faker->word,
        'numero' => $this->faker->numberBetween(1, 100),
        'pessoa_id' => $pessoa->id,
    ];

    $casa = $casaService->create($data);

    expect($casa)->toBeInstanceOf(\App\Models\Casa::class);
    expect($casa->endereco)->toEqual($data['endereco']);
    expect($casa->pessoa_id)->toEqual($data['pessoa_id']);
});
test('it can update a casa', function () {
    $casaService = new CasaService();
    $pessoaService = new PessoaService();

    $dataPessoa = [
        'nome' => $this->faker->name,
        'telefone' => $this->faker->phoneNumber,
    ];
    $pessoa = $pessoaService->create($dataPessoa);

    $casa = $casaService->create(
         [
        'endereco' => $this->faker->address,
        'bairro' => $this->faker->word,
        'cidade' => $this->faker->city,
        'provincia' => $this->faker->word,
        'numero' => $this->faker->numberBetween(1, 100),
        'pessoa_id' => $pessoa->id,
    ]
    );

    $data = [
        'endereco' => $this->faker->address,
        'bairro' => $this->faker->word,
        'cidade' => $this->faker->city,
        'provincia' => $this->faker->word,
        'numero' => $this->faker->numberBetween(1, 100),
        'pessoa_id' => $pessoa->id,
    ];

    $updatedCasa = $casaService->update($casa, $data);


    expect($pessoa->nome)->toEqual($dataPessoa['nome']);
    expect($pessoa->id)->toEqual($data['pessoa_id']);
    expect($updatedCasa)->toBeInstanceOf(\App\Models\Casa::class);
    expect($updatedCasa->endereco)->toEqual($data['endereco']);
    expect($updatedCasa->pessoa_id)->toEqual($data['pessoa_id']);
});
test('it can delete a casa', function () {
    $casaService = new CasaService();
    $pessoaService = new PessoaService();

    $dataPessoa = [
        'nome' => $this->faker->name,
        'telefone' => $this->faker->phoneNumber,
    ];
    $pessoa = $pessoaService->create($dataPessoa);

    $casa = $casaService->create(
         [
        'endereco' => $this->faker->address,
        'bairro' => $this->faker->word,
        'cidade' => $this->faker->city,
        'provincia' => $this->faker->word,
        'numero' => $this->faker->numberBetween(1, 100),
        'pessoa_id' => $pessoa->id,
    ]
    );
    $casaService->delete($casa);
    expect(\App\Models\Casa::find($casa->id))->toBeNull();
});
test('it can get all casas', function () {
    $casaService = new CasaService();
    $pessoaService = new PessoaService();

    $dataPessoa = [
        'nome' => $this->faker->name,
        'telefone' => $this->faker->phoneNumber,
    ];
    $pessoa = $pessoaService->create($dataPessoa);

    \App\Models\Casa::factory()->count(5)->create(
         [
        'endereco' => $this->faker->address,
        'bairro' => $this->faker->word,
        'cidade' => $this->faker->city,
        'provincia' => $this->faker->word,
        'numero' => $this->faker->numberBetween(1, 100),
        'pessoa_id' => $pessoa->id,
    ]
    );
    $casas = $casaService->getAll();
    expect($casas)->toHaveCount(5);
});
test('it can get a casa by id', function () {
    $casaService = new CasaService();
    $pessoaService = new PessoaService();

    $dataPessoa = [
        'nome' => $this->faker->name,
        'telefone' => $this->faker->phoneNumber,
    ];
    $pessoa = $pessoaService->create($dataPessoa);

    $casa = $casaService->create(
         [
        'endereco' => $this->faker->address,
        'bairro' => $this->faker->word,
        'cidade' => $this->faker->city,
        'provincia' => $this->faker->word,
        'numero' => $this->faker->numberBetween(1, 100),
        'pessoa_id' => $pessoa->id,
    ]
    );

    $foundCasa = $casaService->getById($casa->id);

    expect($foundCasa)->toBeInstanceOf(\App\Models\Casa::class);
    expect($foundCasa->id)->toEqual($casa->id);
});
test('it can search casas by endereco or bairro', function () {
    $casaService = new CasaService();
    $pessoaService = new PessoaService();

    $dataPessoa = [
        'nome' => $this->faker->name,
        'telefone' => $this->faker->phoneNumber,
    ];
    $pessoa = $pessoaService->create($dataPessoa);

    $casa1 = $casaService->create(
         [
        'endereco' => 'Rua A',
        'bairro' => 'Bairro A',
        'cidade' => $this->faker->city,
        'provincia' => $this->faker->word,
        'numero' => $this->faker->numberBetween(1, 100),
        'pessoa_id' => $pessoa->id,
    ]
    );
    $casa2 = $casaService->create(
         [
        'endereco' => 'Rua B',
        'bairro' => 'Bairro B',
        'cidade' => $this->faker->city,
        'provincia' => $this->faker->word,
        'numero' => $this->faker->numberBetween(1, 100),
        'pessoa_id' => $pessoa->id,
    ]
    );

    // Search by endereco
    $result = $casaService->search('Rua A');
    expect($result)->toHaveCount(1);
    expect($result[0]->id)->toEqual($casa1->id);

    // Search by bairro
    $result = $casaService->search('Bairro B');
    expect($result)->toHaveCount(1);
    expect($result[0]->id)->toEqual($casa2->id);
});
