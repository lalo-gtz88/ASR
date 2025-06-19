<?php

namespace App\Livewire;

use App\Models\Marca;
use App\Models\Modelo;
use Livewire\Component;

class MarcasCat extends Component
{

    public $idMarca;
    public $nombre;
    public $search = "";
    public $modoEditar = false;
    public $marcaSeleccionada;
    public $modelo;
    public $modelos = [];

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
        $marcas = $this->getMarcas();
        $this->modelos = $this->getModelos();
        return view('livewire.marcas-cat', compact('marcas'));
    }

    function getMarcas()
    {

        return Marca::orderBy('nombre')->paginate(20);
    }

    function getModelos()
    {

        return Modelo::orderBy('nombre')->get();
    }

    public function guardar()
    {

        $this->validate([
            'nombre' => 'required'
        ]);

        if (!$this->modoEditar) {
            $marca = new Marca();
            $marca->nombre = $this->nombre;
            $marca->save();
        } else {

            $marca = Marca::find($this->idMarca);
            $marca->nombre = $this->nombre;
            $marca->save();
        }

        $this->restore();
        $this->dispatch('alerta', msg: 'Cambios guardados!', type: 'success');
    }

    public function edit($id)
    {
        $marca = Marca::find($id);
        $this->idMarca = $marca->id;
        $this->nombre = $marca->nombre;
        $this->modoEditar = true;
    }

    public function restore()
    {
        $this->reset('modoEditar', 'nombre', 'idMarca');
    }

    public function delItem($id)
    {
        $marca = Marca::find($id);
        $marca->active = 0;
        $marca->save();
        $this->dispatch('alerta', msg: 'Registro eliminado!', type: 'success');
        $this->reset();
    }

    function nuevoModelo($marca)
    {
        $marcaS = Marca::find($marca);
        $this->idMarca = $marcaS->id;
        $this->marcaSeleccionada = $marcaS->nombre;

        $this->dispatch('showModalModelos');
    }

    function createModelo()
    {
        $this->validate([
            'modelo' => 'required'
        ]);

        Modelo::create([
            'nombre' => $this->modelo,
            'marca_id' => $this->idMarca,
            'foto' => ''
        ]);

        $this->dispatch('alerta', msg: 'Registro guardado!', type: 'success');
    }
}
