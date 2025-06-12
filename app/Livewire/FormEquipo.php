<?php

namespace App\Livewire;

use App\Models\Equipo;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\TiposEquipo;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithFileUploads;


class FormEquipo extends Component
{

    use WithFileUploads;

    #[Reactive]
    public $uniqueId;
    public $serviceTag;
    public $tipo = 1;
    public $tipos = [];
    public $imgTipo;
    public $marca;
    public $marcas = [];
    public $modelo;
    public $modelos = [];
    public $inventario;
    public $fechaDeAdquisicion;
    public $direccionIp;
    public $direccionMac;
    public $mostrar = false;
    public $editable = false;

    protected $listeners = [
        'refrescar' => '$refresh',
        'guardar'
    ];

    public function mount($ip = null)
    {
        $this->tipos =  $this->getTiposEquipo();
        $this->marcas = $this->getMarcas();

        if ($ip) {
            $this->direccionIp = $ip;
        }

        if ($this->editable) {

            $e = $this->getData($this->uniqueId);

            $this->serviceTag = $e->service_tag;
            $this->tipo = $e->tipo;
            $this->marca = $e->marca;
            $this->modelo = $e->modelo;
            $this->inventario = $e->inventario;
            $this->fechaDeAdquisicion = $e->fecha_adquisicion;
            $this->direccionIp = ($e->direccion_ip) ? $this->obtenerIp($e->direccion_ip)[0]->dir : null;
            $this->direccionMac = $e->direccion_mac;
        }

        $this->modelos = $this->getModelos();
    }

    public function render()
    {
        return view('livewire.form-equipo');
    }


    function updatedTipo()
    {

        $this->dispatch('actualizaTipo', tipo: $this->tipo)->to('InventarioEquipos');
    }

    function getTiposEquipo()
    {
        return TiposEquipo::where('active', 1)->get();
    }

    function getMarcas()
    {

        return Marca::orderBy('nombre')->get();
    }

    function getModelos()
    {

        return Modelo::where('marca_id', $this->marca)
            ->orderBy('nombre')
            ->get();
    }

    function listarModelos()
    {

        $this->modelos = $this->getModelos();

        $this->reset('modelo');

        if (count($this->modelos) > 0) {

            $this->modelo = $this->modelos[0]['id'];
        }
    }

    function convertIP($ip)
    {
        return DB::select("SELECT INET_ATON('{$ip}') as dir");
    }

    function obtenerIp($ip)
    {

        return DB::select("SELECT INET_NTOA('{$ip}') as dir");
    }

    function guardar()
    {

        $this->validate([
            'serviceTag' => 'required',
            'direccionIp' => 'ip|nullable',
            'direccionMac' => 'mac_address|nullable',
        ]);

        $ip = ($this->direccionIp) ? $this->convertIP($this->direccionIp) : null;
        $id = ($this->uniqueId) ? $this->uniqueId : null;

        $data = [
            'id' => $id,
            'serviceTag' => $this->serviceTag,
            'tipo' => $this->tipo,
            'inventario' => $this->inventario,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'fechaDeAdquisicion' => $this->fechaDeAdquisicion,
            'direccionIp' =>  $ip,
            'direccionMac' => $this->direccionMac,
        ];

        $this->dispatch("guardarEquipo{$this->tipo}", dataEquipo: $data);
    }

    function getData($id)
    {
        return Equipo::find($id);
    }
}
