<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calca extends Model
{
    /** @use HasFactory<\Database\Factories\CalcaFactory> */
    use HasFactory;

    protected $fillable = [
        'cor', // Color of the pants
        'quantidade', // Quantity of the pants
    ];

    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}
