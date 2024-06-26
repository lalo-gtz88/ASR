<?php

namespace App\Http\Livewire;

use App\Models\DetalleDiagnostico;
use App\Models\Diagnostico;
use App\Models\Equipo;
use App\Models\Seguimiento;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ListDiagnosticos extends Component
{
    use WithPagination;

    public $search;

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

  


    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $diagnosticos = Diagnostico::leftJoin('users', 'users.id', 'diagnosticos.id_user')
            ->leftJoin('detalle_diagnosticos', 'detalle_diagnosticos.id_diagnostico', 'diagnosticos.id')
            ->where('active', 1)
            ->where(function ($q) {
                $q->where('diagnosticos.nombre_sol', 'like', '%' . $this->search . '%');
                $q->orWhere('diagnosticos.dictamen', 'like', '%' . $this->search . '%');
                $q->orWhere('diagnosticos.cargo_sol', 'like', '%' . $this->search . '%');
            })
            ->select(DB::raw("diagnosticos.*, CONCAT_WS(' ',users.name, users.lastname) AS realizado, count(detalle_diagnosticos.id) AS numElementos"))
            ->groupBy('diagnosticos.id')
            ->paginate(20);


        return view('livewire.list-diagnosticos', compact('diagnosticos'));
    }

    public function delItem($index)
    {
        unset($this->agregados[$index]);
    }
}
