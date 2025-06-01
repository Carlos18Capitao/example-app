<?php

namespace App\Services;
use App\Models\Casa;
use App\Services\PhotoService;
use App\Services\PaginationPresenter;


class CasaService {

    protected PhotoService $photoService;
    public function __construct(
    ) {
        $this->photoService = new PhotoService();
    }

    public function create(array $data): Casa
    {
        return Casa::create($data);
    }

    public function update(Casa $casa, array $data): Casa
    {
        $casa->update($data);
        return $casa;
    }

    public function delete(Casa $casa): void
    {
        foreach ($casa->photos as $photo) {
            $this->photoService->delete($photo);
        }
        $casa->delete();
        return;
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Casa::with(['pessoa', 'photos'])->withCount('pessoa')->get();
    }

    public function getById(int $id): ?Casa
    {
        return Casa::findOrFail($id)->with(['pessoa', 'photos'])->first();
    }

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null)
    {
        $result = Casa::with(['pessoa','photos'])
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('endereco', 'like', "%{$filter}%");
                }
            })
            ->paginate($totalPerPage, ['*'], 'page', $page);
#dd($result);
        return new PaginationPresenter($result);
    }

    public function search(string $query): \Illuminate\Database\Eloquent\Collection
    {
        return Casa::where('endereco', 'like', "%{$query}%")->get();
    }

}
