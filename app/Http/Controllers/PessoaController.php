<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Faker\Calculator\Inn;
use Illuminate\Http\Request;
use App\Http\Requests\PessoaRequest;
use App\Services\PessoaService;
use Inertia\Inertia;

class PessoaController extends Controller
{

    public function __construct(protected PessoaService $pessoaService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pessoas = $this->pessoaService->getAll();
        return Inertia::render('Pessoas/index', [
            'pessoas' => $pessoas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Pessoas/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:15',
        ]);

        $pessoa = $this->pessoaService->create($data);

        return redirect()->route('pessoas.index')->with('success', 'Pessoa criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pessoa $pessoa)
    {
        $pessoaFound = $this->pessoaService->getById($pessoa->id);
        return Inertia::render('Pessoas/show', [
            'pessoa' => $pessoaFound,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pessoa $pessoa)
    {
        return Inertia::render('Pessoas/edit', [
            'pessoa' => $pessoa,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pessoa $pessoa)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:15',
        ]);

        $updatedPessoa = $this->pessoaService->update($pessoa, $data);

        return redirect()->route('pessoas.index')->with('success', 'Pessoa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pessoa $pessoa)
    {
        $this->pessoaService->delete($pessoa);

        return redirect()->route('pessoas.index')->with('success', 'Pessoa excluída com sucesso!');
    }
}
