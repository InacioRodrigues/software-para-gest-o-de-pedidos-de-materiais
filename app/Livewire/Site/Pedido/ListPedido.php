<?php

namespace App\Livewire\Site\Pedido;

use Livewire\Component;
use App\Models\Pedido;

class ListPedido extends Component
{

    public function aprovarPedido($pedidoId)
    {
        $pedido = Pedido::find($pedidoId);
        $grupo = $pedido->grupo;

        if ($pedido->total <= $grupo->saldoPermitido) {
            $pedido->status = 'aprovado';
            $pedido->dataAtualizacao = now();
            $pedido->save();
            session()->flash('message', 'Pedido aprovado com sucesso!');
        } else {
            session()->flash('error', 'Saldo insuficiente para aprovar o pedido.');
        }
    }

    public function rejeitarPedido($pedidoId)
    {
        $pedido = Pedido::find($pedidoId);
        $pedido->status = 'rejeitado';
        $pedido->dataAtualizacao = now();
        $pedido->save();
        session()->flash('message', 'Pedido rejeitado.');
    }

    public function solicitarAlteracoes($pedidoId)
    {
        $pedido = Pedido::find($pedidoId);
        $pedido->status = 'alteracoes_solicitadas';
        $pedido->dataAtualizacao = now();
        $pedido->save();
        session()->flash('message', 'Alterações solicitadas ao pedido.');
    }


    public function render()
    {
        $pedidos = auth()->user()->perfil === 'aprovador'
            ? Pedido::whereHas('grupo', function($query) {
                $query->where('aprovador_id', auth()->id());
            })->get()
            : Pedido::where('solicitante_id', auth()->id())->get();

        return view('livewire.site.pedido.list-pedido', [
             'pedido'=> $pedido
        ]);
    }
}
