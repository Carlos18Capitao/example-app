<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Encomenda extends Model
{
    /** @use HasFactory<\Database\Factories\EncomendaFactory> */
    use HasFactory;
    protected $fillable = [
        'encomendaable_id',
        'encomendaable_type',
        'status',
        'cliente_id',
    ];
    /**
     * Get the parent encomendaable model (Cliente or another model).
     */
    public function encomendaable(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
