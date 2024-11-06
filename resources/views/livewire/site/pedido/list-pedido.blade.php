<div>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-xl font-bold mb-4">Lista de Pedidos</h2>

        @if(session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Solicitante</th>
                        <th class="px-4 py-2">Grupo</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Data Criação</th>
                        <th class="px-4 py-2">Ações</th>
                    </tr>
                </thead>
                @foreach($pedidos as $pedido)
                <tr>
                    <td class="border px-4 py-2">{{ $pedido->id }}</td>
                    <td class="border px-4 py-2">{{ $pedido->solicitante->nome }}</td>
                    <td class="border px-4 py-2">{{ $pedido->grupo->nome }}</td>
                    <td class="border px-4 py-2">R$ {{ number_format($pedido->total, 2) }}</td>
                    <td class="border px-4 py-2">
                        <span class="px-2 py-1 rounded text-sm
                            @if($pedido->status === 'aprovado') bg-green-200 text-green-800
                            @elseif($pedido->status === 'rejeitado') bg-red-200 text-red-800
                            @elseif($pedido->status === 'alteracoes_solicitadas') bg-yellow-200 text-yellow-800
                            @else bg-blue-200 text-blue-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $pedido->status)) }}
                        </span>
                    </td>
                    <td class="border px-4 py-2">{{ $pedido->dataCriacao }}</td>
                    <td class="border px-4 py-2">
                        @if(auth()->user()->perfil === 'aprovador' && $pedido->status === 'novo')
                            <button wire:click="aprovarPedido({{ $pedido->id }})"
                                    class="bg-green-500 text-white px-2 py-1 rounded mr-2">
                                Aprovar
                            </button>
                            <button wire:click="rejeitarPedido({{ $pedido->id }})"
                                    class="bg-red-500 text-white px-2 py-1 rounded mr-2">
                                Rejeitar
                            </button>
                            <button wire:click="solicitarAlteracoes({{ $pedido->id }})"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded">
                                Solicitar Alterações
                            </button>
                        @endif
                        <button wire:click="verDetalhes({{ $pedido->id }})"
                                class="bg-blue-500 text-white px-2 py-1 rounded">
                            Ver Detalhes
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
