<?php

namespace App\Http\Livewire;

use App\Models\Almacen;
use Livewire\Component;
use Livewire\WithPagination;

class CatAlmacenes extends Component
{
    use WithPagination;


    public $almEdit;
    public $editar = false;
    public $nameAlmacen;
    

    public function render()
    {
        $almacenes = $this->getAlmacenes();
        return view('livewire.cat-almacenes', compact('almacenes'));
    }

    function getAlmacenes() {
        
        return Almacen::orderBy('nombre')->paginate(15);
    }

    function store() {
        
        $alm = new Almacen();
        $alm->nombre = $this->nameAlmacen;
        $alm->save();
        $this->reset('nameAlmacen');
        $this->dispatchBrowserEvent('alerta', ['type'=>'success', 'msg'=>'Registro guardado!']);
    }

    function edit($id) {
        
        $this->almEdit =  Almacen::find($id);
        $this->nameAlmacen = $this->almEdit->nombre;
        $this->editar = true;
        
    }

    function update() {
        
        $this->almEdit->nombre = $this->nameAlmacen;
        $this->almEdit->save();
        $this->editar = false;
        $this->dispatchBrowserEvent('alerta', ['type'=>'success', 'msg'=>'Registro guardado!']);

    }

    function cancelar() {
        
        $this->reset('editar', 'almEdit', 'nameAlmacen');
    }
}
