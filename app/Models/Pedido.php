<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'total',
        'status',
        'data_criacao',
        'data_atualizacao',
        'solicitante_id',
        'grupo_id'
    ];

    protected $casts = [
        'data_criacao' => 'datetime',
        'data_atualizacao' => 'datetime',
    ];

    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solicitante_id');
    }

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class);
    }

    public function materiais(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'pedido_has_materias')
            ->withPivot('quantidade', 'subtotal')
            ->withTimestamps();
    }

    public function calcularTotal()
    {
        $this->total = $this->materiais()
            ->get()
            ->sum(function ($material) {
                return $material->pivot->subtotal;
            });
        $this->save();
    }
}
