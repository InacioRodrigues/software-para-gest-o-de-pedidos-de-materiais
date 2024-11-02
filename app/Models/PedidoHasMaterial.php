<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoHasMaterial extends Model
{

    protected $table = 'pedido_has_materias';

    public $incrementing = true;

    protected $fillable = [
        'pedido_id',
        'material_id',
        'quantidade',
        'subtotal'
    ];

    protected $casts = [
        'quantidade' => 'integer',
        'subtotal' => 'decimal:2'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function recalcularSubtotal()
    {
        $material = $this->material;
        $this->subtotal = $material->preco * $this->quantidade;
        $this->save();

        // Recalcula o total do pedido
        $this->pedido->calcularTotal();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pedidoMaterial) {
            if (!$pedidoMaterial->subtotal) {
                $material = Material::find($pedidoMaterial->material_id);
                $pedidoMaterial->subtotal = $material->preco * $pedidoMaterial->quantidade;
            }
        });

        static::updating(function ($pedidoMaterial) {
            if ($pedidoMaterial->isDirty('quantidade')) {
                $material = Material::find($pedidoMaterial->material_id);
                $pedidoMaterial->subtotal = $material->preco * $pedidoMaterial->quantidade;
            }
        });
    }
}

