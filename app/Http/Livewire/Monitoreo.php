<?php

namespace App\Http\Livewire;

use App\Jobs\ProccessEmail;
use App\Mail\NotificationTickets;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Categoria;
use App\Models\departamento;
use App\Models\edificio;
use App\Models\Seguimiento;
use App\Models\VReports;
use Exception;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Mail;

class Monitoreo extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $filtro_status = "ABIERTO";
    public $search = "";
    public $usuarios = [];
    public $categorias = [];
    public $modalshow = false;

    //datos para nuevo ticket
    public $tema = "";
    public $descripcion = "";
    public $prioridad = "Media";
    public $quien_reporta = "";
    public $telefono = "";
    public $edificio = "";
    public $edificios = [];
    public $departamento = "";
    public $departamentos = [];
    public $ip = "";
    public $usuario_red = "";
    public $asignado = "";
    public $categoria = "";
    public $autoriza = "";
    public $attachment;


    public $readyToLoad = false; //propiedad usada para mostrar Loading... antes de renderizar tabla de tickets; se establece por default en false

    protected $paginationTheme = 'bootstrap'; //para usar la paginacion de livewire con bootstrap 
    protected $listeners = [
        'restore'
    ];

    public function updatingSearch()
    {
        $this->resetPage(); //para resetear a la primera pagina cuando tenemos paginacion y filtrado 
    }

    public function updatedFiltroStatus()
    {
        $this->resetPage(); //para resetear a la primera pagina cuando tenemos paginacion y filtrado 
    }

    public function updated()
    {
        $this->resetPage(); //para resetear a la primera pagina cuando tenemos paginacion y filtrado 
    }

    public function loadTickets()
    {
        $this->readyToLoad = true; // Cuando mandas llamar este metodo estableces la propiedad en true para indicar que muestre la info
    }

    public function render()
    {

        $tickets = Ticket::leftJoin('users as asignados', 'asignados.id', 'tickets.asignado')
            ->leftJoin('users as creadores', 'creadores.id', 'tickets.creador')
            ->select(DB::raw('tickets.*,
                                        asignados.name as asignado, 
                                        creadores.name as creador,
                                        asignados.photo'))
            ->where('tickets.active', 1)
            ->where('tickets.status', $this->filtro_status)
            ->where(function ($q) {
                $q->where('tickets.id', 'LIKE', $this->search);
                $q->orWhere('tickets.tema', 'LIKE', "%" . $this->search . "%");
                $q->orWhere('tickets.descripcion', 'LIKE', "%" . $this->search . "%");
            })
            ->orderBy('id', 'DESC')
            ->paginate(20);


        $totalTickets = Ticket::where('status', 'Abierto')->get();
        $ticketsDone = Ticket::where('status', 'Abierto')->where('prioridad', 'Baja')->get();
        $ticketsWarning = Ticket::where('status', 'Abierto')->where('prioridad', 'Media')->get();
        $ticketsDanger = Ticket::where('status', 'Abierto')->where('prioridad', 'Alta')->get();

        //Sacamos los reportes levantados en TELMEX
        $rpts = DB::connection('mysql_second')->table('v_reports')
            ->where('estatus', '')
            ->orderBy('rhalta')
            ->get();



        return view('livewire.monitoreo', compact('tickets', 'totalTickets', 'ticketsDone', 'ticketsWarning', 'ticketsDanger', 'rpts'))->layout('layouts.appBlank');
    }

    public function restore()
    {
        //limpiamos modal
        $this->reset(
            'tema',
            'descripcion',
            'prioridad',
            'quien_reporta',
            'telefono',
            'edificio',
            'departamento',
            'descripcion',
            'ip',
            'usuario_red',
            'asignado',
            'categoria',
            'autoriza',
            'attachment'
        );
    }

    public function actualizar()
    {
        $this->emitTo('charts', 'actualizar');
        $this->render();
    }
}
