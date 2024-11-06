<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>Novo Pedido</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Selecione os Materiais:</label>
                <select class="form-control" wire:model="material_id">
                    <option value="">Selecione um material</option>
                    @foreach($materiais as $material)
                        <option value="{{ $material->id }}">
                            {{ $material->nome }} - R$ {{ number_format($material->preco, 2, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <h4>Materiais Selecionados</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Quantidade</th>
                            <th>Subtotal</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidoMateriais as $index => $item)
                            <tr>
                                <td>{{ $item['nome'] }}</td>
                                <td>{{ $item['quantidade'] }}</td>
                                <td>R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</td>
                                <td>
                                    <button wire:click="removeMaterial({{ $index }})" class="btn btn-danger btn-sm">
                                        Remover
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><strong>Total:</strong></td>
                            <td colspan="2">R$ {{ number_format($total, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <button wire:click="createPedido" class="btn btn-primary mt-3">
                Criar Pedido
            </button>
        </div>
    </div>
</div>
