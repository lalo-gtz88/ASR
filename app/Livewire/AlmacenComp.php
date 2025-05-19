<?php

namespace App\Livewire;

use App\Models\Almacen;
use App\Models\departamento;
use App\Models\edificio;
use App\Models\EqStock;
use App\Models\Seguimiento;
use App\Models\Ticket;
use App\Models\TiposEquipo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;


class AlmacenComp extends Component
{

    use WithPagination;

    public $listAlmacenes = [];
    public $search;
    public $filtroTipo;
    public $tipoID = "DSI";
    public $etiqueta;
    public $tipoEq = 'CPU';
    public $notas;
    public $almacenID = "";
    public $idEq;
    public $editar = false;
    public $tiposEquipos = [];
    public $destino = "ASIGNAR EQUIPO";
    public $tecnico;
    public $tecnicos = [];
    public $quien_reporta;
    public $edificio;
    public $departamento;
    public $autoriza;
    public $prioridad = 'Baja'; 
    public $fecha_de_atencion;
    public $edificios =[];
    public $departamentos =[];
    public $eqSalidaID;
    public $cat_tipos_equipos = [];
    public $orderTable = 'asc';
    public $orderField = 'et';
    public $condicion = "NUEVO";

    protected $listeners = ['reload', 'delete'];


    public function render()
    {
        $this->getAlmacenes();
        $this->getTiposEq();
        $this->getTecnicos();
        $this->getTiposEquipos();
        $this->departamentos = departamento::where('active', 1)->orderBy('nombre')->get();
        $this->edificios = edificio::where('active', 1)->orderBy('nombre')->get();

        $equipos = $this->getEquipos();
        return view('livewire.almacen-comp', compact('equipos'));
    }


    public function updatedSearch()
    {
        $this->resetPage();
    }

    function getAlmacenes()
    {

        $this->listAlmacenes = Almacen::all();
    }

    function getEquipos()
    {

        return EqStock::leftJoin('almacenes', 'eq_stock.alm_id', 'almacenes.id')
            ->leftJoin('users as creadores', 'creadores.id', 'eq_stock.user_created_id')
            ->leftJoin('users as editores', 'editores.id', 'eq_stock.user_updated_id')
            ->select(DB::raw("eq_stock.*, almacenes.nombre as almacen, CONCAT_WS('',creadores.name,creadores.lastname) AS creador,
                        CONCAT_WS('',editores.name,editores.lastname) AS editor"))
            ->where(function ($q) {
                $q->where('et', 'LIKE', '%'. $this->search .'%');
                $q->orWhere('almacenes.nombre', 'LIKE', '%' . $this->search . '%');
                $q->orWhere('eq_stock.not', 'LIKE', '%' . $this->search . '%');
            })
            ->where('eq_stock.tip', 'LIKE', '%' . $this->filtroTipo . '%')
            ->where('eq_stock.deleted', null)
            ->where('eq_stock.asignado', null)
            ->orderBy($this->orderField, $this->orderTable)
            ->get();
    }

    function getTecnicos()
    {

        $this->tecnicos = User::where('activo', 1)
            ->where('tecnico', 1)
            ->where('id', '!=', 1)
            ->get();
    }

    function  getTiposEquipos() {
        
        $this->cat_tipos_equipos = TiposEquipo::get();

    }

    function store()
    {

        $eq = [

            'alm_id' => $this->almacenID,
            'user_created_id' => Auth::user()->id,
            'et' => $this->etiqueta,
            'tip' => $this->tipoEq,
            'not' => $this->notas,
            'tip_id' => $this->tipoID,
            'condicion' => $this->condicion
        ];

        EqStock::insert($eq);
        $this->dispatch('alerta', ['type' => 'success', 'msg' => 'Registro guardado!']);
        $this->dispatch('closeModal');
    }

    function edit($id)
    {

        $eq = EqStock::find($id);
        $this->idEq = $eq->id;
        $this->almacenID = $eq->alm_id;
        $this->etiqueta = $eq->et;
        $this->tipoEq = $eq->tip;
        $this->notas = $eq->not;
        $this->condicion = $eq->condicion;
        $this->tipoID = $eq->tip_id;
        $this->editar = true;

        $this->dispatch('editar');
    }

    function update()
    {

        $e = EqStock::find($this->idEq);
        $e->alm_id = $this->almacenID;
        $e->et = $this->etiqueta;
        $e->tip = $this->tipoEq;
        $e->not = $this->notas;
        $e->condicion = $this->condicion;
        $e->tip_id = $this->tipoID;
        $e->user_updated_id = Auth::user()->id;

        $e->save();
        $this->dispatch('alerta', ['type' => 'success', 'msg' => 'Cambios guardados!']);
    }

    function reload()
    {

        $this->resetExcept('listAlmacenes', 'search', 'filtroTipo', 'eqSalida');
    }

    function getTiposEq()
    {

        $this->tiposEquipos = TiposEquipo::get();
    }

    function showModalSalida($id) {
     
        $this->eqSalidaID = EqStock::find($id)->id;
        $this->dispatch('shoModalSalida');
        
    }

    function saveSalida()
    {

        if ($this->destino == 'ASIGNAR EQUIPO') {

            $this->validate([

                'tecnico' => 'required',
                'prioridad' => 'required',
                'departamento' => 'required',
            ]);

            //Modificamos el status del Equipo
            $eq = EqStock::find($this->eqSalidaID);
            $eq->asignado = true;
            $eq->save();


            //Generamos nuevo ticket
            $ticket = new Ticket();
            $ticket->tema = 'INSTALACION DEL EQUIPO '. $eq->not. ' CON '  . $eq->tip_id. ' '. $eq->et;
            $ticket->descripcion = 'FAVOR DE HACER LA INSTALACION DEL EQUIPO '. $eq->not. ' CON '  . $eq->tip_id. ' '. $eq->et;
            $ticket->asignado = $this->tecnico;
            $ticket->creador = Auth::user()->id;
            $ticket->prioridad = $this->prioridad;
            $ticket->categoria = $eq->tip;
            $ticket->status = "Abierto";
            $ticket->reporta = $this->quien_reporta;
            $ticket->departamento = $this->departamento;
            $ticket->edificio = $this->edificio;
            $ticket->autoriza = $this->autoriza;
            $ticket->fecha_atencion = $this->fecha_de_atencion;
            $ticket->usuario = Auth::user()->id;
            $ticket->save();

            //Guardamos la primera nota del ticket
            $seguimiento = new Seguimiento();
            $seguimiento->notas = 'FAVOR DE HACER LA INSTALACION DEL EQUIPO '. $eq->not. ' CON '  . $eq->tip_id. ' '. $eq->et;
            $seguimiento->ticket = $ticket->id;
            $seguimiento->usuario = Auth::user()->id;
            $seguimiento->save();

            //mandamos alerta
            $this->dispatch('alerta', ['type'=>'success', 'msg'=> 'Cambios guardados!']);

            //escondemos el modal
            $this->dispatch('closeModal');
        }
    }

    function delete() {
        
        $e = EqStock::find($this->eqSalidaID);
        $e->deleted = true;
        $e->save();
        $this->dispatch('alerta', ['type'=>'success', 'msg'=> 'Equipo dado de baja!']);
        $this->dispatch('closeModal');
    }

    function orderEq($field) {   

        if($this->orderField == $field){
         
            if($this->orderTable == 'desc')
                $this->orderTable = 'asc';
            else
                $this->orderTable = 'desc';
        }else{
            
            $this->orderTable = 'asc';
        }

        $this->orderField = $field;
        $this->getEquipos();
        
    }

    public function downloadFormat()
    {
        return Storage::download('exports/Formato_equipos.xlsx');
    }
}
