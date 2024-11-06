<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Grupo;
use App\Models\User;

class GrupoForm extends Component
{
    public $nome;
    public $saldoPermitido;
    public $aprovador_id;
    public $grupo;
    public $editMode = false;

    protected $rules = [
        'nome' => 'required|string|max:45',
        'saldoPermitido' => 'required|numeric|min:0',
        'aprovador_id' => 'required|exists:usuarios,id'
    ];

    public function mount($grupoId = null)
    {
        if ($grupoId) {
            $this->grupo = Grupo::find($grupoId);
            $this->nome = $this->grupo->nome;
            $this->saldoPermitido = $this->grupo->saldoPermitido;
            $this->aprovador_id = $this->grupo->aprovador_id;
            $this->editMode = true;
        }
    }

    public function salvar()
    {
        $this->validate();

        if ($this->editMode) {
            $this->grupo->update([
                'nome' => $this->nome,
                'saldoPermitido' => $this->saldoPermitido,
                'aprovador_id' => $this->aprovador_id
            ]);
            session()->flash('message', 'Grupo atualizado com sucesso!');
        } else {
            Grupo::create([
                'nome' => $this->nome,
                'saldoPermitido' => $this->saldoPermitido,
                'aprovador_id' => $this->aprovador_id
            ]);
            session()->flash('message', 'Grupo criado com sucesso!');
        }

        return redirect()->route('grupos.index');
    }

    public function render()
    {
        return view('livewire.admin.grupo-form', [
            'aprovadores' => User::where('perfil', 'aprovador')->get()
        ]);
    }

   /* public function render()
    {
        return view('livewire.admin.grupo-form');
    }
        */
}
