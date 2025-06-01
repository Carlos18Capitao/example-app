<?php

namespace App\Services;
use App\Models\Cliente;

class ClienteServices
{

    public function novo(array $dados){

        $cliente = new Cliente();
        $cliente->nome = $dados['nome'];
        $cliente->email = $dados['email'];
        $cliente->telefone = $dados['telefone'];
        $cliente->save();

        return $cliente;
    }

    public function ver(){

    }

    public function listar(){

    }

    public function apagar(){

    }

    public function atualizar(){

    }
}