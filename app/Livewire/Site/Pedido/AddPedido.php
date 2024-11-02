<?php

namespace App\Livewire\Site\Pedido;

use Livewire\Component;
use App\Models\Pedido;
use App\Models\Material;

class AddPedido extends Component
{

    public $materiais;
    public $pedidoMateriais = [];
    public $total = 0;

    public function mount()
    {
        $this->materiais = Material::all();
    }
    public function addMaterial($materialId, $quantidade)
    {
        $material = Material::find($materialId);
        $subtotal = $material->preco * $quantidade;
        $this->pedidoMateriais[] = [
            'material_id' => $materialId,
            'quantidade' => $quantidade,
            'subtotal' => $subtotal,
        ];
        $this->total += $subtotal;
    }

    public function createPedido()
    {
        $pedido = Pedido::create([
            'solicitante_id' => Auth::id(),
            'grupo_id' => Auth::user()->grupo_id,
            'total' => $this->total,
            'status' => 'novo',
        ]);

        foreach ($this->pedidoMateriais as $material) {
            PedidoHasMaterial::create([
                'pedido_id' => $pedido->id,
                'material_id' => $material['material_id'],
                'quantidade' => $material['quantidade'],
                'subtotal' => $material['subtotal'],
            ]);
        }

        session()->flash('message', 'Pedido criado com sucesso!');
        return redirect()->route('solicitante.pedidos');
    }

    public function render()
    {
        return view('livewire.site.pedido.add-pedido');
    }
}
