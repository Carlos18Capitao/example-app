<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Services\ClienteServices;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ClienteController extends Controller
{
    public function __construct(protected ClienteServices $clienteServices)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $clientes = $this->clienteServices->listar($search ?? '');
        return Inertia('Clients/index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia('Clients/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request)
    {
        $this->clienteServices->novo($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        $cliente = $this->clienteServices->ver($cliente->id);
        return Inertia('clients.show', [
            'cliente' => $cliente,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return Inertia('clients.edit', [
            'cliente' => $cliente,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $this->clienteServices->atualizar($cliente->id, $request->all());
        return redirect()->route('clients.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $this->clienteServices->apagar($cliente->id);
        return redirect()->route('clients.index')->with('success', 'Cliente excluído com sucesso!');
    }
}
