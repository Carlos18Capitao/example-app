<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casaco extends Model
{
    /** @use HasFactory<\Database\Factories\CasacoFactory> */
    use HasFactory;
    protected $fillable = [
        'cor', // Color of the jacket
        'quantidade', // Quantity of the jackets
    ];

    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}
