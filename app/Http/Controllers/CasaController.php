<?php

namespace App\Http\Controllers;

use App\Models\Casa;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCasaRequest;
use App\Http\Requests\UpdateCasaRequest;
use App\Http\Resources\CasaResource;
use App\Services\CasaService;
use Inertia\Inertia;
use App\Models\Pessoa;
use App\Services\PessoaService;
use App\Services\PhotoService;

class CasaController extends Controller
{
    public function __construct(
        private CasaService $casaService,
        private PhotoService $photoService
    )
    {
        $this->casaService = $casaService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $casas = $this->casaService->
        paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 6),
            filter: $request->filter,);
        return Inertia::render('Casas/index', [
            'casas' => $casas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $pessoaId)
    {
        $pessoa = new PessoaService();
        #dd($pessoaId, $pessoa->getById($pessoaId));
        return Inertia::render('Casas/create', [
            'pessoa' => $pessoa->getById($pessoaId),
        ]);
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

        return redirect()->route('pessoas.show', $data['pessoa_id'])->with('success', 'Casa criada com sucesso!');
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
        $id = $casa->pessoa_id;
        $this->casaService->delete($casa);
        return redirect()->route('pessoas.show', $id)->with('success', 'Casa excluída com sucesso!');
    }
}
