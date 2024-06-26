<?php

namespace App\Http\Livewire;

use App\Models\DetalleDiagnostico;
use App\Models\Diagnostico;
use App\Models\Equipo;
use App\Models\Seguimiento;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NuevoDiagnostico extends Component
{

    
    public $nombre_del_solicitante;
    public $cargo_del_solicitante;
    public $extension_del_solicitante;
    public $buscar;
    public $encontrados = [];
    public $agregados = [];

    //datos del equipo
    public $idEquipo;
    public $DSI;
    public $service_tag;
    public $descripcion;
    public $responsable;
    public $diagnostico;
    public $marca;
    public $dictamen = "BAJA DEFINITIVA DE ACTIVO(S) POR SER INCOSTEABLE SU REPARACION";

    public $asocTicket;
    public $numTicket;

    protected $listeners = ['setEquipo', 'delDiagnostico'];

    public function updatingBuscar()
    {
        $this->encontrados = [];
    }

    public function render()
    {
        return view('livewire.nuevo-diagnostico');
    }

    public function searchEquipo()
    {
        if (strlen($this->buscar) > 2) {

            $this->encontrados = Equipo::where('active', 1)
                ->where('dsi', 'like', '%' . $this->buscar . '%')->get();
        } else {
            $this->encontrados = [];
        }
    }

    public function setEquipo($id)
    {
        $eq = Equipo::find($id);
        $this->idEquipo = $eq->id;
        $this->DSI = $eq->dsi;
        $this->service_tag = $eq->st;
        $this->descripcion = $eq->descr;
        $this->marca = $eq->marca;
        $this->responsable = $eq->responsable;
        $this->reset('encontrados');
    }
    public function agregar()
    {
        if ($this->idEquipo) {
            array_push($this->agregados, [

                'dsi' => $this->DSI,
                'st' => $this->service_tag,
                'descripcion' => $this->descripcion,
                'marca' => $this->marca,
                'desc_diagnostico' => $this->diagnostico,
                'responsable' => $this->responsable,
            ]);

            $this->reset(
                'service_tag',
                'DSI',
                'descripcion',
                'diagnostico',
                'marca',
                'responsable'
            );
            $this->dispatchBrowserEvent('focusBuscar');
        }
    }

    public function store()
    {
        $this->validate([

            'nombre_del_solicitante' => 'required',
            'cargo_del_solicitante' => 'required',
        ]);

        if ($this->numTicket != null) {
            $ticket = Ticket::find($this->numTicket);
            if($ticket == null){
                
                $this->dispatchBrowserEvent('alerta', ['msg' => 'No existe el número de ticket', 'type' => 'error']);
                return;
                

            }
        }
        if (count($this->agregados) > 0) {

            $obj = new Diagnostico();
            $obj->nombre_sol = $this->nombre_del_solicitante;
            $obj->cargo_sol = $this->cargo_del_solicitante;
            $obj->ext_sol = $this->extension_del_solicitante;
            $obj->dictamen = $this->dictamen;
            $obj->id_user = Auth::user()->id;
            $obj->save();

            foreach ($this->agregados as $item) {

                $item['id_diagnostico'] = $obj->id;
                DetalleDiagnostico::insert($item);
            }

            //asociamos el diagnostico al un ticket
            if ($this->numTicket != null) {

                //Guardamos una nota en el ticket
                $seguimiento = new Seguimiento();
                $seguimiento->notas = "Se asocia el diagnóstico #". $obj->id. ".-".$obj->dictamen;
                $seguimiento->print = 1;
                $seguimiento->ticket = $this->numTicket;
                $seguimiento->usuario = Auth::user()->id;
                $seguimiento->id_diagnostico = $obj->id;
                $seguimiento->save();
            }

            $this->dispatchBrowserEvent('alerta', ['msg' => 'Registro guardado!', 'type' => 'success']);
            $this->dispatchBrowserEvent('printDoc', ['id' => $obj->id]);
            $this->reset();
        } else
            $this->addError('noAgregados', 'No se encontrarón elementos agregados para el diagnóstico');
    }

    public function delDiagnostico($id)
    {
        $dx = Diagnostico::find($id);
        $dx->active = 0;
        $dx->save();

        $this->dispatchBrowserEvent('alerta', ['msg' => 'Registro eliminado!', 'type' => 'success']);
    }
}
