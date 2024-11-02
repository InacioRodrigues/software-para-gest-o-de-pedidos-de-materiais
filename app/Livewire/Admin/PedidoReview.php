<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pedido;
use App\Models\Grupo;

class PedidoReview extends Component
{


    public function render()
    {
        return view('livewire.admin.pedido-review');
    }
}
