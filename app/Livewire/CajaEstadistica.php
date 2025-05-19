<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;

class CajaEstadistica extends Component
{

    public $etiqueta;
    public $metodo;
    public $color;
    public $icon;


    protected $listeners = ['ticket-saved' => '$refresh'];

    public function mount($etiqueta = null, $metodo = null, $color=null, $icon=null)
    {
        $this->etiqueta = $etiqueta;
        $this->metodo = $metodo;
        $this->color = $color;
        $this->icon = $icon;
    }

    public function render()
    {

        switch ($this->metodo) {

            case 'totalTickets':
                $total = $this->getTotalTickets();
                break;
            case 'pendientes':
                $total = $this->getPendientes();
                break;
            case 'asignados':
                $total = $this->getAsignados();
                break;
            case 'bajos':
                $total = $this->getPrioridad('Baja');
                break;
            case 'medios':
                $total = $this->getPrioridad('Media');
                break;
            case 'altos':
                $total = $this->getPrioridad('Alta');
                break;
        }

        return view('livewire.caja-estadistica', compact('total'));
    }


    function getTotalTickets()
    {

        return Ticket::where('active', 1)
            ->where('status', 'ABIERTO')
            ->get()->count();
    }

    function getPendientes()
    {

        return Ticket::where('active', 1)
            ->where('status', 'PENDIENTE')
            ->get()->count();
    }

    function getAsignados()
    {

        return Ticket::where('active', 1)
            ->where('asignado', '!=', 0)
            ->where('status', '=', 'ABIERTO')
            ->get()->count();
    }

    function getPrioridad($prio)
    {

        return Ticket::where('active', 1)
            ->where('prioridad', $prio)
            ->where('status', '=', 'ABIERTO')
            ->get()->count();
    }
}
