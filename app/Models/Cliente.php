<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    /** @use HasFactory<\Database\Factories\ClienteFactory> */
    use HasFactory;
    protected $fillable = [
        'nome',
        'email',
        'telefone',
    ];
    /**
     * Get the orders associated with the client.
     */
    public function encomendas(): HasMany
    {
        return $this->hasMany(Encomenda::class);
    }
}
