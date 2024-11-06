<?php

namespace App\Livewire\Site\Pedido;

use Livewire\Component;
use App\Models\Pedido;
use App\Models\Material;
use App\Models\PedidoHasMaterial;

class AddPedido extends Component
{
    public $materiais;
    public $pedidoMateriais = [];
    public $total = 0;
    public $grupo;

    protected $rules = [
        'pedidoMateriais.*.quantidade' => 'required|numeric|min:1',
        'pedidoMateriais.*.material_id' => 'required|exists:materiais,id'
    ];

    public function mount()
    {
        $this->materiais = Material::all();
        $this->grupo = auth()->user()->grupo;
    }

    public function addMaterial($materialId, $quantidade)
    {
        $material = Material::findOrFail($materialId);
        $subtotal = $material->preco * $quantidade;

        $this->pedidoMateriais[] = [
            'material_id' => $materialId,
            'quantidade' => $quantidade,
            'subtotal' => $subtotal,
            'nome' => $material->nome // Opcional: para exibir na view
        ];

        $this->total = collect($this->pedidoMateriais)->sum('subtotal');
    }

    public function removeMaterial($index)
    {
        $this->total -= $this->pedidoMateriais[$index]['subtotal'];
        unset($this->pedidoMateriais[$index]);
        $this->pedidoMateriais = array_values($this->pedidoMateriais);
    }

    public function createPedido()
    {
        $this->validate();

        try {
            \DB::transaction(function () {
                $pedido = Pedido::create([
                    'solicitante_id' => auth()->id(),
                    'grupo_id' => auth()->user()->grupo_id,
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
            });

            session()->flash('message', 'Pedido criado com sucesso!');
            return redirect()->route('solicitante.pedidos');

        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao criar pedido. Por favor, tente novamente.');
        }
    }

    public function render()
    {
        return view('livewire.site.pedido.add-pedido')->layout('layouts.site');
    }
}
