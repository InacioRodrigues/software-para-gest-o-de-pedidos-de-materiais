<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitante extends Model
{
    protected $fillable = [
        'user_id',
        'grupo_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class);
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'solicitante_id', 'user_id');
    }
}
