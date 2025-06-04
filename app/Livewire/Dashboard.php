<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $openCount;
    public $inProgressCount;
    public $unAssigned;
    public $statusLabels = [];
    public $statusData = [];
    public $dailyLabels = [];
    public $dailyData = [];
    public $userLabels = [];
    public $userData = [];
    public $edificioLabels = [];
    public $edificioData = [];

    public function mount()
    {

        $this->obtenerDatos();
    }

    public function render()
    {
        $this->obtenerDatos();
        return view('livewire.dashboard');
    }

    function obtenerDatos()
    {

        //tickets por status
        $this->openCount = Ticket::where('status', 'Abierto')->where('active', 1)->count();
        $this->inProgressCount = Ticket::where('status', 'Pendiente')->where('active', 1)->count();
        $this->unAssigned = Ticket::where('status', 'Abierto')
            ->where('active', 1)
            ->where(function ($q) {
                $q->where('asignado', 0);
                $q->orWhere('asignado', 1);
            })->count();

        $this->statusLabels = ['Abierto', 'Pendiente', 'Sin asignar'];
        $this->statusData = [$this->openCount, $this->inProgressCount, $this->unAssigned];


        //Tickets por dia
        $dailyTickets = Ticket::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get()
            ->reverse();

        $this->dailyLabels = $dailyTickets->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))->toArray();
        $this->dailyData = $dailyTickets->pluck('total')->toArray();


        //Tickets por usuario 
        $ticketsByUser = Ticket::select('asignado', DB::raw('count(*) as total'))
            ->where('active', 1)
            ->whereNotNull('asignado')
            ->where('status', 'abierto')
            ->groupBy('asignado')
            ->with('tecnico') // usamos la relacion
            ->get();

        $this->userLabels = $ticketsByUser->map(fn($t) => optional($t->tecnico)->name ?? 'Desconocido')->toArray();
        $this->userData = $ticketsByUser->pluck('total')->toArray();

        //Tickets por edificio
        $ticketsByEdificio = Ticket::select('edificio', DB::raw('count(*) as total'))
            ->where('status', 'Abierto')
            ->where('active', 1)
            ->where('asignado', '!=', 0)
            ->groupBy('edificio')
            ->get();

        $this->edificioLabels = $ticketsByEdificio->pluck('edificio')->toArray();
        $this->edificioData = $ticketsByEdificio->pluck('total')->toArray();
    }
}
