<?php

namespace App\Services;

use App\Models\Cliente;
use App\Providers\Eloquent\ClienteEloquentORM;

class ClienteServices
{
    protected $clienteEloquentORM;

    public function __construct()
    {
        $this->clienteEloquentORM = new ClienteEloquentORM();
    }

    public function novo(array $dados): Cliente {
        return $this->clienteEloquentORM->create($dados);
    }

    public function ver(int $id): Cliente{
        $cliente = $this->clienteEloquentORM->read($id);
        if (!$cliente) {
            throw new \Exception("Cliente não encontrado");
        }
        return $cliente;
    }

    public function listar(string $search = ''): array {
        return $this->clienteEloquentORM->readAll( $search);
    }

    public function apagar(int $id): bool {
        
        return $this->clienteEloquentORM->delete($id);
    }

    public function atualizar(int $id, array $dados): Cliente {
        $cliente = $this->clienteEloquentORM->read($id);
        if (!$cliente) {
            throw new \Exception("Cliente não encontrado");
        }
        return $this->clienteEloquentORM->update($id, $dados);
    }
}