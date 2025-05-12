<?php

namespace App\Livewire;

use App\Models\Enlace;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class EditarEnlace extends Component
{

    #[Reactive]
    public $uniqueId;
    public $sitio_id;
    public $sitios = [];
    public $proveedorId;
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

    function mount() {
        
        $this->editar();
    }

    public function render()
    {
        return view('livewire.editar-enlace');
    }

    function editar()
    {

        $en = Enlace::find($this->uniqueId);
        $this->referencia = $en->referencia;
        $this->sitio_id = $en->sitio_id;
        $this->proveedorId = $en->proveedor_id;
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

    function actualizar()
    {

        $this->validate([

            'referencia' => 'required',
            'descripcion' => 'required',
            'telefono' => 'required',
            'sitio_id' => 'required',
            'domicilio' => 'required',
            'proveedorId' => 'required',

        ]);

        $en = Enlace::find($this->uniqueId);
        $en->referencia = $this->referencia;
        $en->sitio_id = $this->sitio_id;
        $en->proveedor_id = $this->proveedorId;
        $en->telefono = $this->telefono;
        $en->domicilio = $this->domicilio;
        $en->status  = 'ok';
        $en->contacto = $this->contacto;
        $en->descripcion = $this->descripcion;
        $en->tipo = $this->tipo;
        $en->servicios = $this->servicio;
        $en->area = $this->area;
        $en->observaciones = $this->observaciones;
        $en->lat = $this->lat;
        $en->lng = $this->lng;
        $en->save();

        $this->dispatch('alerta', msg: "Cambios guardados!", type: 'success');

    }

    //evento para recibir el valor del componente proveedor
    function obtenerProveedor($proveedor)
    {

        $this->proveedorId = $proveedor;
    }

    //evento para recibir las coordenadas del marker en el map
    #[On('setLatLng')]
    function setLatLng($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    #[On('setearProveedor')]
    function setearProveedor() {
        
        $this->dispatch('setProveedor', $this->proveedorId);
    }
}
