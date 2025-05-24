<?php

namespace App\Services;

use App\Models\Pessoa;
use App\Services\PhotoService;
use App\Services\PaginationPresenter;

class PessoaService
{
    public PhotoService $photoService;
    public function __construct(
    ) {}

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
        $this->photoService = new PhotoService;
        // Deletar todas as fotos associadas à pessoa usando o PhotoService
        foreach ($pessoa->photos as $photo) {
            $this->photoService->delete($photo);
        }

        $pessoa->casas()->each(function ($casa) {
            // Deletar todas as fotos associadas às casas
            foreach ($casa->photos as $photo) {
                $this->photoService->delete($photo);
            }
            // Deletar a casa
            $casa->delete();
        });

        $pessoa->delete();
        return;
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Pessoa::with(['casas.photos', 'photos'])->get();
    }

    public function getById(int $id): ?Pessoa
    {
        return Pessoa::with(['casas.photos', 'photos'])
            ->withCount('casas')
            ->findOrFail($id);
    }

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null)
    {
        $result = Pessoa::with('casas.photos', 'photos')
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('nome', 'like', "%{$filter}%");
                    $query->orWhere('telefone', 'like', "%{$filter}%");
                }
            })
            ->paginate($totalPerPage, ['*'], 'page', $page);
#dd($result);
        return new PaginationPresenter($result);
    }

    public function search(string $query): \Illuminate\Database\Eloquent\Collection
    {
        return Pessoa::where('nome', 'like', "%{$query}%")
            ->orWhere('telefone', 'like', "%{$query}%")
            ->with('photos')
            ->get();
    }
}
