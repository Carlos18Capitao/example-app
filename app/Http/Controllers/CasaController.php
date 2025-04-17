<?php

namespace App\Http\Controllers;

use App\Models\Casa;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCasaRequest;
use App\Http\Requests\UpdateCasaRequest;
use App\Http\Resources\CasaResource;
use App\Services\CasaService;
use Inertia\Inertia;

class CasaController extends Controller
{
    public function __construct(private CasaService $casaService)
    {
        $this->casaService = $casaService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $casas = $this->casaService->getAll();
        return Inertia::render('Casas/Index', [
            'casas' => $casas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Casas/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'endereco' => 'required|string|max:100',
            'bairro' => 'required|string|max:50',
            'cidade' => 'required|string|max:50',
            'provincia' => 'required|string|max:50',
            'numero' => 'required|string|max:10',
            'pessoa_id' => 'required|exists:pessoas,id',
        ]);

        $casa = $this->casaService->create($data);

        return redirect()->route('casas.index')->with('success', 'Casa criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Casa $casa)
    {
        $casa = $this->casaService->getById($casa->id);
        return Inertia::render('Casas/Show', [
            'casa' => $casa,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Casa $casa)
    {
        return Inertia::render('Casas/Edit', [
            'casa' => $casa,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Casa $casa)
    {
        $data = $request->validate([
            'endereco' => 'required|string|max:100',
            'bairro' => 'required|string|max:50',
            'cidade' => 'required|string|max:50',
            'provincia' => 'required|string|max:50',
            'numero' => 'required|string|max:10',
            'pessoa_id' => 'required|exists:pessoas,id',
        ]);

        $updatedCasa = $this->casaService->update($casa, $data);

        return redirect()->route('casas.index')->with('success', 'Casa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Casa $casa)
    {
        $this->casaService->delete($casa);

        return redirect()->route('casas.index')->with('success', 'Casa excluída com sucesso!');
    }
}
