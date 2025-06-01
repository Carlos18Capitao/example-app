<?php 

namespace App\Providers\Eloquent;


use App\Providers\Contracts\PersistInterface;

use App\Models\Cliente;

class ClienteEloquentORM implements PersistInterface
{
    /**
     * Create a new resource.
     *
     * @param array $data
     * @return Cliente
     */
    public function create(array $data): Cliente
    {
        return Cliente::create($data);
    }

    /**
     * Retrieve a resource by its ID.
     *
     * @param int $id
     * @return Cliente|null
     */
    public function read(int $id): ?Cliente
    {
        return Cliente::findOrFail($id);
    }

    /**
     * Retrieve all resources.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Cliente[]
     */
    public function readAll(): array {
        return Cliente::all()->toArray();
    }

    /**
     * Update an existing resource.
     *
     * @param int $id
     * @param array $data
     * @return Cliente|null
     */
    public function update(int $id, array $data): ?Cliente
    {
        $cliente = $this->read($data['id'] ?? $id);
        if ($cliente) {
            $cliente->update($data);
            return $cliente;
        }
        return null;
    }

    /**
     * Delete a resource by its ID.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool
    {
        $cliente = $this->read($id);
        if ($cliente) {
            return $cliente->delete();
        }
        return null;
    }
}