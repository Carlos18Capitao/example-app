<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function encomendaable()
    {
        return $this->morphTo();
    }
}
