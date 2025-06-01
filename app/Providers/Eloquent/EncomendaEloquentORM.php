<?php 

namespace App\Providers\Eloquent;
use App\Providers\Contracts\PersistInterface;
use App\Models\Encomenda;

class EncomendaEloquentORM implements PersistInterface
{
    /**
     * Create a new resource.
     *
     * @param array $data
     * @return Encomenda
     */
    public function create(array $data): Encomenda
    {
        return Encomenda::create($data);
    }

    /**
     * Retrieve a resource by its ID.
     *
     * @param int $id
     * @return Encomenda|null
     */
    public function read(int $id): ?Encomenda
    {
        return Encomenda::findOrFail($id);
    }

    /**
     * Retrieve all resources.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Encomenda[]
     */
    public function readAll(): array {
        return Encomenda::all()->toArray();
    }

    /**
     * Update an existing resource.
     *
     * @param int $id
     * @param array $data
     * @return Encomenda|null
     */
    public function update(int $id, array $data): ?Encomenda
    {
        $encomenda = $this->read($data['id'] ?? $id);
        if ($encomenda) {
            $encomenda->update($data);
            return $encomenda;
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
        $encomenda = $this->read($id);
        if ($encomenda) {
            return $encomenda->delete();
        }
        return null;
    }
    /**
     * Retrieve all orders for a specific client.
     *
     * @param int $clienteId
     * @return \Illuminate\Database\Eloquent\Collection|Encomenda[]
     */
    public function readByCliente(int $clienteId): array
    {
        return Encomenda::where('cliente_id', $clienteId)->get()->toArray();
    }
}