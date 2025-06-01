<?php
use App\Services\ClienteServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

uses(RefreshDatabase::class, WithFaker::class);

# php artisan test --filter=ClienteTest

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
test('ver cliente', function () {
    $dados = [
        'nome' => $this->faker->name,
        'email' => $this->faker->unique()->safeEmail,
        'telefone' => $this->faker->phoneNumber,
    ];

    $clienteService = new ClienteServices();
    $cliente = $clienteService->novo($dados);
    $clienteId = $cliente->id;

    $clienteVerificado = $clienteService->ver($clienteId);

    expect($clienteVerificado)->toBeInstanceOf(App\Models\Cliente::class);
    expect($clienteVerificado->id)->toBe($clienteId);
});
test('listar clientes', function () {
    $dados1 = [
        'nome' => $this->faker->name,
        'email' => $this->faker->unique()->safeEmail,
        'telefone' => $this->faker->phoneNumber,
    ];
    $dados2 = [
        'nome' => $this->faker->name,
        'email' => $this->faker->unique()->safeEmail,
        'telefone' => $this->faker->phoneNumber,
    ];

    $clienteService = new ClienteServices();
    $clienteService->novo($dados1);
    $clienteService->novo($dados2);

    $clientes = $clienteService->listar();

    expect($clientes)->toBeArray();
    expect(count($clientes))->toBeGreaterThanOrEqual(2);
});
test('atualizar cliente', function () {
    $dados = [
        'nome' => $this->faker->name,
        'email' => $this->faker->unique()->safeEmail,
        'telefone' => $this->faker->phoneNumber,
    ];

    $clienteService = new ClienteServices();
    $cliente = $clienteService->novo($dados);
    $clienteId = $cliente->id;

    $dadosAtualizados = [
        'nome' => 'Nome Atualizado',
        'email' => 'carlos@gmail.com',
        'telefone' => '123456789',
    ];
    $clienteAtualizado = $clienteService->atualizar($clienteId, $dadosAtualizados);
    expect($clienteAtualizado)->toBeInstanceOf(App\Models\Cliente::class);
    expect($clienteAtualizado->id)->toBe($clienteId);
    expect($clienteAtualizado->nome)->toBe($dadosAtualizados['nome']);
    expect($clienteAtualizado->email)->toBe($dadosAtualizados['email']);
    expect($clienteAtualizado->telefone)->toBe($dadosAtualizados['telefone']);
});
test('apagar cliente', function () {
    $dados = [
        'nome' => $this->faker->name,
        'email' => $this->faker->unique()->safeEmail,
        'telefone' => $this->faker->phoneNumber,
    ];

    $clienteService = new ClienteServices();
    $cliente = $clienteService->novo($dados);
    $clienteId = $cliente->id;

    $resultado = $clienteService->apagar($clienteId);
    expect($resultado)->toBeTrue();

    // Verifica se o cliente foi realmente apagado
    $this->expectException(\Exception::class);
    $clienteService->ver($clienteId);
}); 