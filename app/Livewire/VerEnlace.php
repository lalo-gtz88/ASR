<?php

namespace App\Livewire;

use App\Models\edificio;
use App\Models\Enlace;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class VerEnlace extends Component
{
    #[Reactive]
    public $uniqueId;
    public $sitio;
    public $proveedor;
    public $telefono;
    public $domicilio;
    public $referencia;
    public $status;
    public $contacto;
    public $descripcion;
    public $tipo;
    public $servicio;
    public $area;
    public $observaciones;
    public $lat;
    public $lng;
    

    function mount()
    {

        $this->uniqueId;
        $this->show();
    }

    public function render()
    {
        return view('livewire.ver-enlace');
    }

    function show()
    {

        $en = Enlace::find($this->uniqueId);
        $this->referencia = $en->referencia;
        $this->sitio = $en->relSitio->nombre;
        $this->proveedor = $en->relProveedor->nombre;
        $this->telefono = $en->telefono;
        $this->domicilio = $en->domicilio;
        $this->status = $en->status;
        $this->contacto = $en->contacto;
        $this->descripcion = $en->descripcion;
        $this->tipo = $en->tipo;
        $this->servicio = $en->servicios;
        $this->area = $en->area;
        $this->observaciones = $en->observaciones;
        $this->lat = $en->lat;
        $this->lng = $en->lng;

    }

    #[On('borrar')]
    function eliminar($id) {
        
        Enlace::find($id)->delete();
        $this->dispatch('alerta', msg: "Registro eliminado", type: 'success');
        $this->dispatch('volverEnlaces');
    }
}
