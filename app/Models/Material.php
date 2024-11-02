<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'nome',
        'preco'
        ];

    public function pedidos(): BelongsToMany
    {
        return $this->belongsToMany(Pedido::class, 'pedido_has_materias')
            ->withPivot('quantidade', 'subtotal')
            ->withTimestamps();
    }
}
