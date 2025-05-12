<?php

namespace App\Livewire;

use App\Models\Equipo;
use App\Models\Printer;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class FormImpresora extends Component
{
    public $uniqueId;
    #[Reactive]
    public $equipoId;
    public $proveedor;
    public $aColor = false;
    public $multifuncional;

    public $editable;


    protected $listeners = ['guardarEquipo3'=> 'guardarCambios'];

    public function mount()
    {
        if ($this->editable) {

            $this->editar($this->equipoId);
        }
    }

    public function render()
    {
        return view('livewire.form-impresora');
    }

    //se obtienen los datos para mostrar
    public function editar($id)
    {

        $p = Printer::where('equipo_id', $id)->first();
        $this->uniqueId = $p->id;
        $this->aColor = ($p->color == 1)? true: false;
        $this->multifuncional = ($p->multifuncional == 1)? true: false;
        $this->proveedor = $p->proveedor;

    }

    function guardarCambios($dataEquipo)
    {
        if ($this->editable){
            $e = Equipo::find($dataEquipo['id']);
            $p = Printer::where('equipo_id', $this->equipoId)->first();
            $msj = "Cambios guardados!";

        }else{
            $e = new Equipo();
            $p = new Printer();
            $msj = "Registro guardado!";
        }

        $this->guardarEquipo($e, $dataEquipo);
        $this->guardarPrinter($p, $e);

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

    function guardarPrinter(Printer $ptr, $e=null)
    {
        if($e)
            $ptr->equipo_id = $e->id;

        $ptr->multifuncional = $this->multifuncional;
        $ptr->color = $this->aColor;
        $ptr->proveedor = $this->proveedor;
        
        $ptr->save();
    }

    function actualizarPrinter() {
        
        $pc = Printer::where('equipo_id', $this->equipoId)->first();
        $msj = "Cambios guardados!";
        $this->guardarPrinter($pc);
        $this->dispatch('alerta', msg: $msj, type: 'success');
    }
}
