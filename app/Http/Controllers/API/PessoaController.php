<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Services\PessoaService;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    private $pessoaService;

    public function __construct(PessoaService $pessoaService)
    {
        $this->pessoaService = $pessoaService;
    }

    public function index()
    {
        return response()->json($this->pessoaService->getAll());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:15',
        ]);

        $pessoa = $this->pessoaService->create($data);

        return response()->json($pessoa, 201);
    }

    public function show(int $id)
    {
        $pessoa = $this->pessoaService->getById($id);

        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa not found'], 404);
        }

        return response()->json($pessoa);
    }

    public function update(Request $request, int $id)
    {
        $pessoa = $this->pessoaService->getById($id);

        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa not found'], 404);
        }

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:15',
        ]);

        $updatedPessoa = $this->pessoaService->update($pessoa, $data);

        return response()->json($updatedPessoa);
    }

    public function destroy(int $id)
    {
        $pessoa = $this->pessoaService->getById($id);

        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa not found'], 404);
        }

        $this->pessoaService->delete($pessoa);

        return response()->noContent();
    }
}
