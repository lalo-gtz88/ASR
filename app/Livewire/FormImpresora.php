<?php

namespace App\Livewire;

use App\Models\Equipo;
use App\Models\Printer;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class FormImpresora extends Component
{
    public $equipoId;
    public $proveedor="JMAS", $aColor = false, $multifuncional=false;
    

    protected $listeners = ['guardarEquipo3'=> 'guardarCambios'];

    public function mount($equipoId = null)
    {
        if($equipoId){

            $this->editar($equipoId);
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
        $this->equipoId = $p->equipo_id;
        $this->aColor = ($p->color == 1)? true: false;
        $this->multifuncional = ($p->multifuncional == 1)? true: false;
        $this->proveedor = $p->proveedor;

    }

    function guardarCambios($dataEquipo)
    {
        if ($this->equipoId){

            $ip = ($dataEquipo['direccionIp'])? $dataEquipo['direccionIp'][0]['dir']: null;

            if ($this->equipoId){

                $eq = Equipo::find($this->equipoId);
                $eq->update([
                    'service_tag'=>$dataEquipo['serviceTag'],
                    'tipo'=>$dataEquipo['tipo'],
                    'inventario'=>$dataEquipo['inventario'],
                    'marca'=>  $dataEquipo['marca'],
                    'modelo'=> $dataEquipo['modelo'],
                    'fecha_adquisicion'=>$dataEquipo['fechaDeAdquisicion'],
                    'direccion_ip'=> $ip,
                    'direccion_mac'=> $dataEquipo['direccionMac'],
                ]);


                $prt = Printer::where('equipo_id', $this->equipoId)->first();
                $prt->update([
                    'equipo_id'=> $eq->id,
                    'proveedor' => $this->proveedor,
                    'multifuncional'=> $this->multifuncional,
                    'color'=> $this->aColor
                ]);

                $msj = "Cambios guardados!";

            }else{

                $ip = $dataEquipo['direccionIp'][0]['dir'];
                $eq = Equipo::create([
                    'service_tag'=>$dataEquipo['serviceTag'],
                    'tipo'=>$dataEquipo['tipo'],
                    'inventario'=>$dataEquipo['inventario'],
                    'marca'=>  $dataEquipo['marca'],
                    'modelo'=> $dataEquipo['modelo'],
                    'fecha_adquisicion'=>$dataEquipo['fechaDeAdquisicion'],
                    'direccion_ip'=> $ip,
                    'direccion_mac'=> $dataEquipo['direccionMac'],
                ]);

                Printer::create([
                    'equipo_id'=> $eq->id,
                    'proveedor' => $this->proveedor,
                    'multifuncional'=>$this->multifuncional,
                    'color'=>$this->aColor,
                ]);

        
                $msj = "Registro guardado!";
            }
            
            $this->dispatch('alerta', msg: $msj, type: 'success');
            $this->dispatch('refrescar')->to('InventarioEquipos');
        }
    }
}
