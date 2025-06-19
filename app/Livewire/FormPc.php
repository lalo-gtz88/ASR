<?php

namespace App\Livewire;

use App\Models\Equipo;
use App\Models\PC;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class FormPc extends Component
{

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

    protected $listeners = [

        'refrescar' => '$refresh',
        'guardarEquipo1' => 'guardarCambios', //guardar cambios en una pc desktop
        'guardarEquipo2' => 'guardarCambios', //guardar cambios en una pc laptop
        'actualizar' => 'actualizarPC'

    ];

    public function mount($equipoId = null)
    {
        //$this->equipoId  = $equipoId;

        if ($equipoId) {
            $this->editar($equipoId);
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
        $this->equipoId = $pc->id;
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

        $ip = ($dataEquipo['direccionIp']) ? $dataEquipo['direccionIp'][0]['dir'] : null;

        if ($this->equipoId) {

            $eq = Equipo::find($dataEquipo['id']);
            $eq->update([
                'service_tag' => $dataEquipo['serviceTag'],
                'tipo' => $dataEquipo['tipo'],
                'inventario' => $dataEquipo['inventario'],
                'marca' =>  $dataEquipo['marca'],
                'modelo' => $dataEquipo['modelo'],
                'fecha_adquisicion' => $dataEquipo['fechaDeAdquisicion'],
                'direccion_ip' => $ip,
                'direccion_mac' => $dataEquipo['direccionMac'],
            ]);

            $pc = PC::where('equipo_id', $this->equipoId)->first();
            $pc->update([

                'equipo_id' => $this->equipoId,
                'nombre_equipo' => $this->nombreDeEquipo,
                'ram' => $this->ram,
                'hdd' => $this->hdd,
                'sdd' => $this->sdd,
                'sistema_operativo' => $this->sistemaOperativo,
                'usuario' => $this->usuario,
                'usuario_red' => $this->usuarioRed,
                'monitores' => $this->monitores,
            ]);

            $msj = "Cambios guardados!";
        } else {

            $eq = Equipo::create([
                'service_tag' => $dataEquipo['serviceTag'],
                'tipo' => $dataEquipo['tipo'],
                'inventario' => $dataEquipo['inventario'],
                'marca' =>  $dataEquipo['marca'],
                'modelo' => $dataEquipo['modelo'],
                'fecha_adquisicion' => $dataEquipo['fechaDeAdquisicion'],
                'direccion_ip' => $ip,
                'direccion_mac' => $dataEquipo['direccionMac'],
            ]);

            PC::create([
                'equipo_id' => $eq->id,
                'nombre_equipo' => $this->nombreDeEquipo,
                'ram' => $this->ram,
                'hdd' => $this->hdd,
                'sdd' => $this->sdd,
                'sistema_operativo' => $this->sistemaOperativo,
                'usuario' => $this->usuario,
                'usuario_red' => $this->usuarioRed,
                'monitores' => $this->monitores,
            ]);

            $msj = "Registro guardado!";
        }


        $this->dispatch('alerta', msg: $msj, type: 'success');
    }

    // public function guardarEquipo(Equipo $e, $data)
    // {
    //     $e->service_tag = $data['serviceTag'];
    //     $e->tipo = $data['tipo'];
    //     $e->inventario = $data['inventario'];
    //     $e->marca = $data['marca'];
    //     $e->modelo = $data['modelo'];
    //     $e->fecha_adquisicion = $data['fechaDeAdquisicion'];
    //     $e->direccion_ip = ($data['direccionIp']) ? $data['direccionIp'][0]['dir'] : null;
    //     $e->direccion_mac = $data['direccionMac'];
    //     $e->save();
    // }

    // function guardarPC(PC $pc, $e=null)
    // {
    //     if($e)
    //         $pc->equipo_id = $e->id;

    //     $pc->ram = $this->ram;
    //     $pc->hdd = $this->hdd;
    //     $pc->sdd = $this->sdd;
    //     $pc->sistema_operativo = $this->sistemaOperativo;
    //     $pc->usuario = $this->usuario;
    //     $pc->usuario_red = $this->usuarioRed;
    //     $pc->monitores = $this->monitores;
    //     $pc->nombre_equipo = $this->nombreDeEquipo;
    //     $pc->save();
    // }

    // function actualizarPC() {

    //     $pc = PC::where('equipo_id', $this->equipoId)->first();
    //     $msj = "Cambios guardados!";
    //     $this->guardarPC($pc);
    //     $this->dispatch('alerta', msg: $msj, type: 'success');
    // }
}
