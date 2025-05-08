<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Services\CasaService;
use Illuminate\Http\Request;

class CasaController extends Controller
{
    private $casaService;

    public function __construct(CasaService $casaService)
    {
        $this->casaService = $casaService;
    }

    public function index()
    {
        return response()->json($this->casaService->getAll());
    }

    public function store(Request $request)
    {
        dd($request->all());
        $data = $request->validate([
            'endereco' => 'required|string',
            'sala' => 'required|integer',
            'quarto' => 'required|integer',
            'casaBanho' => 'required|integer',
            'cozinha' => 'required|integer',
            'pessoa_id' => 'required|exists:pessoas,id',
        ]);

        $casa = $this->casaService->create($data);

        return response()->json($casa, 201);
    }

    public function show(int $id)
    {
        $casa = $this->casaService->getById($id);

        if (!$casa) {
            return response()->json(['message' => 'Casa not found'], 404);
        }

        return response()->json($casa);
    }

    public function update(Request $request, int $id)
    {
        $casa = $this->casaService->getById($id);

        if (!$casa) {
            return response()->json(['message' => 'Casa not found'], 404);
        }

        $data = $request->validate([
            'endereco' => 'required|string|max:100',
            'sala' => 'required|integer',
            'quarto' => 'required|integer',
            'casaBanho' => 'required|integer',
            'cozinha' => 'required|integer',
            'pessoa_id' => 'required|exists:pessoas,id',
        ]);

        $updatedCasa = $this->casaService->update($casa, $data);

        return response()->json($updatedCasa);
    }

    public function destroy(int $id)
    {
        $casa = $this->casaService->getById($id);

        if (!$casa) {
            return response()->json(['message' => 'Casa not found'], 404);
        }

        $this->casaService->delete($casa);

        return response()->noContent();
    }
}
