<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Material;

class MaterialForm extends Component
{
    public $nome;
    public $preco;
    public $material;
    public $editMode = false;

    protected $rules = [
        'nome' => 'required|string|max:45',
        'preco' => 'required|numeric|min:0.01'
    ];

    public function mount($materialId = null)
    {
        if ($materialId) {
            $this->material = Material::find($materialId);
            $this->nome = $this->material->nome;
            $this->preco = $this->material->preco;
            $this->editMode = true;
        }
    }
    public function salvar()
    {
        $this->validate();

        if ($this->editMode) {
            $this->material->update([
                'nome' => $this->nome,
                'preco' => $this->preco
            ]);
            session()->flash('message', 'Material atualizado com sucesso!');
        } else {
            Material::create([
                'nome' => $this->nome,
                'preco' => $this->preco
            ]);
            session()->flash('message', 'Material criado com sucesso!');
        }

        return redirect()->route('materiais.index');
    }
    
    public function render()
    {
        return view('livewire.admin.material-form');
    }
}
