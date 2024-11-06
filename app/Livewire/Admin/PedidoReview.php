<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class PedidoReview extends Component
{
    public $pedido;

    public function mount(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    public function approve()
    {
        $grupo = $this->pedido->grupo;
        if ($this->pedido->total <= $grupo->saldoPermitido) {
            $this->pedido->update(['status' => 'aprovado']);
            session()->flash('message', 'Pedido aprovado com sucesso!');
        } else {
            session()->flash('error', 'Saldo insuficiente para aprovação.');
        }
    }

    public function requestChanges()
    {
        $this->pedido->update(['status' => 'alterações solicitadas']);
        session()->flash('message', 'Alterações solicitadas ao pedido.');
    }

    public function reject()
    {
        $this->pedido->update(['status' => 'rejeitado']);
        session()->flash('message', 'Pedido rejeitado.');
    }

    public function render()
    {
        return view('livewire.admin.pedido-review');
    }
}
