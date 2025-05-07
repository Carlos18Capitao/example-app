<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Faker\Calculator\Inn;
use Illuminate\Http\Request;
use App\Http\Requests\PessoaRequest;
use App\Services\PessoaService;
use Inertia\Inertia;
use App\Services\PhotoService;

class PessoaController extends Controller
{

    public function __construct(
        protected PessoaService $pessoaService,
        protected PhotoService $photoService
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pessoas = $this->pessoaService->
        paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 10),
            filter: $request->filter,);

        #dd($pessoas->items());
        return Inertia::render('Pessoas/index', [
            'pessoas' => $pessoas->items(),
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
            'email' => 'nullable|email|max:255',
            'url' => 'nullable|image|max:2048', // Máximo 2MB
        ]);

        $pessoa = $this->pessoaService->create($data);

        if ($request->hasFile('url')) {
            $this->photoService->upload($request->file('url'), $pessoa);
            #$this->photoService->upload($pessoa->photo, $request->file('url'));
        }

        return redirect()->route('pessoas.index')
            ->with('success', 'Pessoa criada com sucesso!');
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
        $pessoa = $this->pessoaService->getById($pessoa->id);
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
            'email' => 'nullable|email|max:255',
            'url' => 'nullable|image|max:2048', // Máximo 2MB
        ]);

        $updatedPessoa = $this->pessoaService->update($pessoa, $data);

        if ($request->hasFile('url')) {
            $this->photoService->update($pessoa->photos->first(), $data);
        }

        return redirect()->route('pessoas.index')
            ->with('success', 'Pessoa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pessoa $pessoa)
    {
        $this->pessoaService->delete($pessoa);
        return redirect()->route('pessoas.index')
            ->with('success', 'Pessoa excluída com sucesso!');
    }
}
