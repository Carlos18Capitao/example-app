<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'encomenda_id',
        'itemable_type',
        'itemable_id',
        'quantidade',
    ];

    /**
     * Get the parent itemable model (Produto or another model).
     */
    public function itemable()
    {
        return $this->morphTo();
    }

    /**
     * Get the encomenda that owns the item.
     */
    public function encomenda()
    {
        return $this->belongsTo(Encomenda::class);
    }
}
