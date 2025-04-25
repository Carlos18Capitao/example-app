<?php
namespace App\Services;
use App\Models\Pessoa;
use App\Services\PhotoService;

class PessoaService
{
    public function __construct(
        protected PhotoService $photoService
    ){}

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
        // Deletar todas as fotos associadas à pessoa usando o PhotoService
        foreach ($pessoa->photos as $photo) {
            $this->photoService->delete($photo);
        }
        
        $pessoa->delete();
        return;
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Pessoa::with(['casas', 'photos'])->get();
    }

    public function getById(int $id): ?Pessoa
    {
        return Pessoa::with(['casas', 'photos'])
            ->withCount('casas')
            ->findOrFail($id);
    }

    public function search(string $query): \Illuminate\Database\Eloquent\Collection
    {
        return Pessoa::where('nome', 'like', "%{$query}%")
            ->orWhere('telefone', 'like', "%{$query}%")
            ->with('photos')
            ->get();
    }
}
