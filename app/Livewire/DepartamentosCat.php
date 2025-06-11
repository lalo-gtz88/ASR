<?php

namespace App\Livewire;

use App\Models\departamento;
use Livewire\Component;
use Livewire\WithPagination;

class DepartamentosCat extends Component
{
    use WithPagination;

    public $idEd;
    public $nombre;
    public $search = "";
    public $editar = false;

    protected $paginationTheme = "bootstrap";

    protected $listeners = [

        'delItem',
    ];

    function updatedSearch()
    {

        $this->resetPage();
    }

    public function render()
    {
        $departamentos = departamento::where('active', 1)
            ->where('nombre', 'like', "%{$this->search}%")
            ->orderBy("nombre")
            ->paginate(10);

        return view('livewire.departamentos-cat', compact('departamentos'));
    }


    public function guardar()
    {

        $this->validate([
            'nombre' => 'required'
        ]);

        if (!$this->editar) {
            $ed = new departamento();
            $ed->nombre = $this->nombre;
            $ed->save();
        } else {

            $ed = departamento::find($this->idEd);
            $ed->nombre = $this->nombre;
            $ed->save();
        }

        $this->restore();
        $this->dispatch('alerta', msg: 'Cambios guardados!', type: 'success');
    }

    public function edit($id)
    {
        $ed = departamento::find($id);
        $this->idEd = $ed->id;
        $this->nombre = $ed->nombre;
        $this->editar = true;
    }

    public function restore()
    {
        $this->reset('editar', 'nombre', 'idEd');
    }

    public function delItem($id)
    {
        $ed = departamento::find($id);
        $ed->active = 0;
        $ed->save();
        $this->dispatch('alerta', msg: 'Registro eliminado!', type: 'success');
        $this->reset();
    }
}
