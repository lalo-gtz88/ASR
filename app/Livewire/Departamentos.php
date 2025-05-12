<?php

namespace App\Livewire;

use App\Models\departamento;
use Livewire\Component;
use Livewire\WithPagination;

class Departamentos extends Component
{
    use WithPagination;
    
    public $idDep;
    public $nombre;
    public $search = "";
    public $editar = false;

    protected $paginationTheme = "bootstrap";

    protected $listeners =[

        'delItem',
    ];

    public function render()
    {
        $departamentos = departamento::where('active', 1)
            ->orderBy("nombre")
            ->paginate(10);

            return view('livewire.departamentos', compact('departamentos'));
    }

    public function store(){

        $this->validate([
            'nombre'=> 'required'
        ]);
        
        $ed = new departamento();
        $ed->nombre = $this->nombre;
        $ed->save();
        $this->dispatchBrowserEvent('alerta',['msg'=> 'Registro guardado']);
        $this->reset();

    }

    public function edit($id)
    {
        $ed = departamento::find($id);
        $this->idDep = $ed->id;
        $this->nombre = $ed->nombre;
        $this->editar = true;
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required'
        ]);

        $dep = departamento::find($this->idDep);
        $dep->nombre = $this->nombre;
        $dep->save();
        $this->dispatchBrowserEvent('alerta', ['msg' => 'Cambios guardados!']);
        $this->reset();
    }

    public function restore()
    {
        $this->reset();
    }

    public function delItem($id)
    {
        $dep = departamento::find($id);
        $dep->active = 0;
        $dep->save();
        $this->dispatchBrowserEvent('alerta', ['msg' => 'Registro eliminado!']);
        $this->reset();
    }
}
