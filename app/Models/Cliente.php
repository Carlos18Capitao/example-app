<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function encomendas()
    {
        return $this->morphMany(Encomenda::class, 'encomendaable');
    }
}
