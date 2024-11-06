<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pedido;

class OrderDetails extends Component
{
    public function mount(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    public function voltar()
    {
        return redirect()->route('pedidos.index');
    }

    public function render()
    {
        return view('livewire.admin.order-details');
    }
}
