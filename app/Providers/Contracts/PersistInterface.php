<?php 

namespace App\Providers\Contracts;

use Illuminate\Database\Eloquent\Model;

interface PersistInterface
{
    /**
     * Create a new resource.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data): Model;

    /**
     * Retrieve a resource by its ID.
     *
     * @param int $id
     * @return mixed
     */
    public function read(int $id): ?Model;

    /**
     * Update an existing resource.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data): ?Model;

    /**
     * Delete a resource by its ID.
     *
     * @param int $id
     * @return mixed
     */
    public function delete(int $id): ?bool;
}