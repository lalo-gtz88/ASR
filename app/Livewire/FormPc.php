<?php

namespace App\Livewire;

use App\Models\Equipo;
use App\Models\PC;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class FormPc extends Component
{

    //propiedades de PC
    public $uniqueId;
    #[Reactive]
    public $equipoId;
    public $ram;
    public $hdd;
    public $sdd;
    public $sistemaOperativo = "Windows 10 Profesional";
    public $usuario;
    public $usuarioRed;
    public $monitores;
    public $nombreDeEquipo;
    //*****************

    public $editable;

    protected $listeners = [

        'refrescar' => '$refresh',
        'guardarEquipo1' => 'guardarCambios', //guardar cambios en una pc desktop
        'guardarEquipo2' => 'guardarCambios', //guardar cambios en una pc laptop
        'actualizar'=> 'actualizarPC'

    ];

    public function mount()
    {
        if ($this->editable) {

            $this->editar($this->equipoId);
        }
    }

    public function render()
    {
        return view('livewire.form-pc');
    }

    //se obtienen los datos para mostrar
    public function editar($id)
    {

        $pc = PC::where('equipo_id', $id)->first();
        $this->uniqueId = $pc->id;
        $this->ram = $pc->ram;
        $this->hdd = $pc->hdd;
        $this->sdd = $pc->sdd;
        $this->sistemaOperativo = $pc->sistema_operativo;
        $this->usuario = $pc->usuario;
        $this->usuarioRed = $pc->usuario_red;
        $this->monitores = $pc->monitores;
        $this->nombreDeEquipo = $pc->nombre_equipo;
    }

    function guardarCambios($dataEquipo)
    {
        if ($this->editable){
            $e = Equipo::find($dataEquipo['id']);
            $pc = PC::where('equipo_id', $this->equipoId)->first();
            $msj = "Cambios guardados!";

        }else{
            $e = new Equipo();
            $pc = new PC();
            $msj = "Registro guardado!";
        }

        $this->guardarEquipo($e, $dataEquipo);
        $this->guardarPC($pc, $e);

        $this->dispatch('alerta', msg: $msj, type: 'success');
        $this->dispatch('refrescar')->to('InventarioEquipos');
    }

    public function guardarEquipo(Equipo $e, $data)
    {
        $e->service_tag = $data['serviceTag'];
        $e->tipo = $data['tipo'];
        $e->inventario = $data['inventario'];
        $e->marca = $data['marca'];
        $e->modelo = $data['modelo'];
        $e->fecha_adquisicion = $data['fechaDeAdquisicion'];
        $e->direccion_ip = ($data['direccionIp']) ? $data['direccionIp'][0]['dir'] : null;
        $e->direccion_mac = $data['direccionMac'];
        $e->save();
    }

    function guardarPC(PC $pc, $e=null)
    {
        if($e)
            $pc->equipo_id = $e->id;

        $pc->ram = $this->ram;
        $pc->hdd = $this->hdd;
        $pc->sdd = $this->sdd;
        $pc->sistema_operativo = $this->sistemaOperativo;
        $pc->usuario = $this->usuario;
        $pc->usuario_red = $this->usuarioRed;
        $pc->monitores = $this->monitores;
        $pc->nombre_equipo = $this->nombreDeEquipo;
        $pc->save();
    }

    function actualizarPC() {
        
        $pc = PC::where('equipo_id', $this->equipoId)->first();
        $msj = "Cambios guardados!";
        $this->guardarPC($pc);
        $this->dispatch('alerta', msg: $msj, type: 'success');
    }
}
