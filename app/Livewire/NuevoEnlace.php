<?php

namespace App\Livewire;

use App\Models\edificio;
use App\Models\Enlace;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Livewire;

class NuevoEnlace extends Component
{

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

    protected $listeners = [
        'obtenerProveedor',
        'setLatLng'
    ];

    function mount()  {
        
        $this->sitios = $this->getSitios();
    }

    public function render()
    {
        return view('livewire.nuevo-enlace');
    }

    function getSitios()
    {

        return edificio::where('active', 1)->get();
    }

    function guardar()
    {
        //dd($this->proveedorId);
        $this->validate([

            'referencia' => 'required',
            'descripcion' => 'required',
            'telefono' => 'required',
            'sitio_id' => 'required',
            'domicilio' => 'required',
            'proveedorId' => 'required',

        ]);

        $en =  new Enlace();
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
        $this->resetExcept('sitios');

        $this->dispatch('alerta', msg: "Registro guardado!", type: 'success');
        
    }

    //evento para recibir el valor del componente proveedor
    function obtenerProveedor($proveedor)
    {

        $this->proveedorId = $proveedor;
    }

    function setLatLng($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }
}
