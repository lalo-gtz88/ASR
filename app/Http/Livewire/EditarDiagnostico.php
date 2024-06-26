<?php

namespace App\Http\Livewire;

use App\Models\DetalleDiagnostico;
use App\Models\Diagnostico;
use App\Models\Equipo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class EditarDiagnostico extends Component
{
    public $search;
    public $idDiagnostico;
    public $nombre_del_solicitante;
    public $cargo_del_solicitante;
    public $extension_del_solicitante;
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

    public $urlPrev;

    public $readyToLoad = false;


    protected $listeners = ['setEquipo'];

    public function mount($id)
    {

        $this->urlPrev = URL::previous();
        $dx = Diagnostico::where('id', $id)
            ->where('active', 1)
            ->first();

        if ($dx != null) {

            $this->idDiagnostico  = $dx->id;
            $this->nombre_del_solicitante  = $dx->nombre_sol;
            $this->cargo_del_solicitante  = $dx->cargo_sol;
            $this->extension_del_solicitante  = $dx->ext_sol;

            $this->agregados = DetalleDiagnostico::where('id_diagnostico', $id)->get()->toArray();
        } else
            return redirect(route('diagnosticos'));
    }

    public function updatingSearch()
    {
        $this->encontrados = [];
    }

    public function render()
    {
        return view('livewire.editar-diagnostico');
    }

    public function searchEquipo()
    {
        if (strlen($this->search) > 2) {

            $this->encontrados = Equipo::where('active', 1)
                ->where('dsi', 'like', '%' . $this->search . '%')->get();
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
                'search',
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

    public function update()
    {
        $this->validate([

            'nombre_del_solicitante' => 'required',
            'cargo_del_solicitante' => 'required',
        ]);

        if (count($this->agregados) > 0) {

            $obj = Diagnostico::find($this->idDiagnostico);
            $obj->nombre_sol = $this->nombre_del_solicitante;
            $obj->cargo_sol = $this->cargo_del_solicitante;
            $obj->ext_sol = $this->extension_del_solicitante;
            $obj->dictamen = $this->dictamen;
            $obj->id_user = Auth::user()->id;
            $obj->save();

            //borramos los elementos exsistentes para volver a ingresar los nuevos
            DetalleDiagnostico::where('id_diagnostico', $this->idDiagnostico)->delete();


            foreach ($this->agregados as $item) {

                $item['id_diagnostico'] = $obj->id;
                DetalleDiagnostico::insert($item);
            }


            $this->dispatchBrowserEvent('alerta', ['msg' => 'Cambios guardados!', 'type' => 'success']);
        } else
            $this->addError('noAgregados', 'No se encontrarón elementos agregados para el diagnóstico');
    }

    public function delItem($index)
    {
        unset($this->agregados[$index]);
    }
}
