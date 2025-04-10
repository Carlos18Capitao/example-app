<?php

namespace App\Services;
use App\Models\Casa;


class CasaService {
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
        $casa->delete();
        return;
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Casa::with('pessoa')->get();
    }

    public function getById(int $id): ?Casa
    {
        return Casa::findOrFail($id)->with('pessoa')->first();
    }
    public function search(string $query): \Illuminate\Database\Eloquent\Collection
    {
        return Casa::where('endereco', 'like', "%{$query}%")
            ->orWhere('bairro', 'like', "%{$query}%")
            ->orWhere('cidade', 'like', "%{$query}%")
            ->orWhere('provincia', 'like', "%{$query}%")
            ->with('pessoa')
            ->get();
    }

}
