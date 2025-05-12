<?php

namespace App\Livewire;

use App\Models\Equipo;
use App\Models\TiposEquipo;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class InventarioEquipos extends Component
{
    //busqueda
    #[Url]
    public $buscar = "";
    #[Url]
    public $param = 'service_tag';
    #[Url]
    public $tipoF = '';
    public $tiposF = [];
    //equipo
    public $tipo = 1;
    public $tipos = [];
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

    protected $listeners = ['refrescar' => '$refresh'];


    function mount()
    {

        $this->getTipos();
    }

    public function render()
    {
        $equipos = $this->getEquipos();

        return view('livewire.inventario-equipos', compact('equipos'));
    }

    #[On('actualizaTipo')]
    function setForm($tipo)
    {

        $this->tipo = $tipo;
    }

    function getEquipos()
    {

        if ($this->param == 'direccion_ip') {

            return $this->getEquiposByIp();

        } else if ($this->param == 'user') {

            return $this->getEquiposByUser();

        } else {

            return $this->getEquiposByOtroParam();
        }
    }

    function getTipos()
    {

        $this->tiposF = TiposEquipo::get();
    }

    function getEquiposByOtroParam()
    {

        return Equipo::leftJoin('pcs', 'pcs.equipo_id', 'equipos.id')
            ->select(DB::raw("equipos.*, pcs.usuario as nombreUsuario,
            INET_NTOA(direccion_ip) as direccion_ip"))
            ->where($this->param, 'LIKE', '%' . $this->buscar . '%')
            ->where('tipo', 'LIKE', '%' . $this->tipoF . '%')
            ->get();
    }

    function getEquiposByIp()
    {

        return Equipo::leftJoin('pcs', 'pcs.equipo_id', 'equipos.id')
            ->select(DB::raw("equipos.*, pcs.usuario as nombreUsuario, 
            INET_NTOA(direccion_ip) as direccion_ip"))
            ->where(DB::raw("INET_NTOA(direccion_ip)"), 'LIKE', '%' . $this->buscar . '%')
            ->where('tipo', 'LIKE', '%' . $this->tipoF . '%')
            ->get();
    }

    function getEquiposByUser()
    {

        if ($this->buscar) {

            return Equipo::leftJoin('pcs', 'pcs.equipo_id', 'equipos.id')
                ->select(DB::raw("equipos.*, pcs.usuario as nombreUsuario,
                INET_NTOA(direccion_ip) as direccion_ip"))
                ->where('tipo', 'LIKE', '%' . $this->tipoF . '%')
                ->where('pcs.usuario', 'LIKE', '%' . $this->buscar . '%')
                ->get();
        } else {

            return Equipo::leftJoin('pcs', 'pcs.equipo_id', 'equipos.id')
                ->select(DB::raw("equipos.*, pcs.usuario as nombreUsuario,
                INET_NTOA(direccion_ip) as direccion_ip"))
                ->where('tipo', 'LIKE', '%' . $this->tipoF . '%')
                ->get();
        }
    }


    #[On('borrar')]
    function delEquipo($id)
    {

        Equipo::find($id)->delete();
        $this->dispatch('alerta', msg: 'Registro eliminado!', type: 'success');
    }
}
