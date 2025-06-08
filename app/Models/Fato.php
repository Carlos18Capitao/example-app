<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fato extends Model
{
    /** @use HasFactory<\Database\Factories\FatoFactory> */
    use HasFactory;
    protected $fillable = [
        'cor', // Color of the suit
        'quantidade', // Quantity of the suits
        'casaco_id', // Foreign key to the casacos table
        'calca_id', // Foreign key to the calcas table
    ];
}
