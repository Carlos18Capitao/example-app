<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casa extends Model
{
    /** @use HasFactory<\Database\Factories\CasaFactory> */
    use HasFactory;
    protected $fillable = [
        'endereco',
        'bairro',
        'cidade',
        'provincia',
        'numero',
        'pessoa_id',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }
    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}
