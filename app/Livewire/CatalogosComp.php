<?php

namespace App\Livewire;

use App\Models\Categoria;
use App\Models\departamento;
use App\Models\edificio;
use Livewire\Component;

class CatalogosComp extends Component
{
    
    public $nombre_edificio = "";
    public $nombre_departamento = "";
    public $nombre_categoria = "";

    public function render()
    {
        $edificios = edificio::orderBy('nombre')->get();
        $departamentos = departamento::orderBy('nombre')->get();
        $categorias = Categoria::orderBy('name')->get();
        return view('livewire.catalogos-comp', compact('edificios','departamentos','categorias'));
    }

    public function storeEdificio()
    {
        $this->validate([
            'nombre_edificio' => 'required' 
        ]);

        $edificio = new edificio();
        $edificio->nombre = $this->nombre_edificio;
        $edificio->save();
        $this->dispatch('alerta', ['msg' => 'Registro guardado!', 'type' => 'success']);
        $this->dispatch('showCollapse');

    }

    public function updateEdificio($id)
    {
        $this->validate([
            'nombre_edificio' => 'required' 
        ]);

        $edificio = edificio::find($id);
        $edificio->nombre = $this->nombre_edificio;
        $edificio->save();
        $this->dispatch('alerta', ['msg' => 'Cambios guardados!', 'type' => 'success']);
        $this->dispatch('showCollapse');
    }

    public function storeDepto()
    {
        $this->validate([
            'nombre_departamento' => 'required' 
        ]);

        $dpto = new departamento();
        $dpto->nombre = $this->nombre_departamento;
        $dpto->save();
        $this->dispatch('alerta', ['msg' => 'Registro guardado!', 'type' => 'success']);
        $this->render();
    }

    public function updateDepto($id)
    {
        $this->validate([
            'nombre_departamento' => 'required' 
        ]);

        $dpto = departamento::find($id);
        $dpto->nombre = $this->nombre_departamento;
        $dpto->save();
        $this->dispatch('alerta', ['msg' => 'Cambios guardados!', 'type' => 'success']);
        $this->render();
    }

    public function storeCategoria()
    {
        $this->validate([
            'nombre_categoria' => 'required' 
        ]);

        $categoria = new Categoria();
        $categoria->name = $this->nombre_categoria;
        $categoria->save();
        $this->dispatch('alerta', ['msg' => 'Registro guardado!', 'type' => 'success']);
        $this->render();
    }

    public function updateCategoria($id)
    {
        $this->validate([
            'nombre_categoria' => 'required' 
        ]);

        $categoria = Categoria::find($id);
        $categoria->name = $this->nombre_categoria;
        $categoria->save();
        $this->dispatch('alerta', ['msg' => 'Cambios guardados!', 'type' => 'success']);
        $this->render();
    }

    
}
