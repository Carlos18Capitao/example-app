<?php
namespace App\Services;
use App\Models\Pessoa;

class PessoaService
{
    public function create(array $data): Pessoa
    {
        return Pessoa::create($data);
    }

    public function update(Pessoa $pessoa, array $data): Pessoa
    {
        $pessoa->update($data);
        return $pessoa;
    }

    public function delete(Pessoa $pessoa): void
    {
        $pessoa->delete();
        return;
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Pessoa::with('casas')->get();
    }
    public function getById(int $id): ?Pessoa
    {
        return Pessoa::findOrFail($id)->with('casas')->withCount('casas')->first();
    }
    public function search(string $query): \Illuminate\Database\Eloquent\Collection
    {
        return Pessoa::where('nome', 'like', "%{$query}%")
            ->orWhere('telefone', 'like', "%{$query}%")
            ->get();
    }
}
