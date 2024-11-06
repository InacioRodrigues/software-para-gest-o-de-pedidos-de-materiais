<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Material;

class MaterialList extends Component
{
    public function deleteMaterial($id)
    {
        $material = Material::find($id);
        if ($material->pedidos()->count() === 0) {
            $material->delete();
            session()->flash('message', 'Material excluído com sucesso!');
        } else {
            session()->flash('error', 'Não é possível excluir material que está em pedidos.');
        }
    }
    
    public function render()
    {
        return view('livewire.admin.material-list');
    }
}
