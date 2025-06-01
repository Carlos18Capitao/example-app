<?php
use App\Services\ClienteServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

uses(RefreshDatabase::class, WithFaker::class);

test('criar cliente', function () {
    $dados = [
        'nome' => $this->faker->name,
        'email' => $this->faker->unique()->safeEmail,
        'telefone' => $this->faker->phoneNumber,
    ];

    $clienteService = new ClienteServices();
    $cliente = $clienteService->novo($dados);

    expect($cliente)->toBeInstanceOf(App\Models\Cliente::class);
    expect($cliente->nome)->toBe($dados['nome']);
    expect($cliente->email)->toBe($dados['email']);
    expect($cliente->telefone)->toBe($dados['telefone']);
});