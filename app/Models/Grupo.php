<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'saldoPermitido', 'aprovador_id'];

    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function aprovador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'aprovador_id');
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }
}
