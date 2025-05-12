<?php

namespace App\Livewire;

use App\Models\Equipo;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class EquipoDetails extends Component
{
    #[Reactive]
    public $uniqueId;
    public $serviceTag;
    public $tipo;
    public $tipoNombre;
    public $marca;
    public $modelo;
    public $inventario;
    public $fechaDeAdquisicion;
    public $direccionIp;
    public $direccionMac;
    public $photo;


    public function mount() {
        
        $e = $this->getData($this->uniqueId);
        
        //set valores
        $this->serviceTag = $e->service_tag;
        $this->inventario = $e->inventario;
        $this->tipo = $e->tipo;
        $this->tipoNombre = $e->relTipoEquipo->nombre;
        $this->marca = $e->relMarca->nombre;
        $this->modelo = $e->relModelo->nombre;
        $this->fechaDeAdquisicion = $e->fecha_adquisicion;
        $this->direccionIp =($e->direccion_ip)? $this->obtenerIP($e->direccion_ip)[0]->dir: null;
        $this->direccionMac = $e->direccion_mac;
        $this->photo = $e->relModelo->foto;

    }

    public function render()
    {
        return view('livewire.equipo-details');
    }

    function getData($id){
        
        return Equipo::find($id);
    }

    function obtenerIP($ip)
    {
        return DB::select("SELECT INET_NTOA('{$ip}') as dir");
    }
}
