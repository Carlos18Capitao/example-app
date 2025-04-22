<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    /** @use HasFactory<\Database\Factories\PessoaFactory> */
    use HasFactory;
    protected $fillable = [
        'nome',
        'telefone',
    ];
    public function casas()
    {
        return $this->hasMany(Casa::class);
    }
    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}
