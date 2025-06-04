<?php

namespace App\Livewire;

use App\Events\CambiosTicket;
use App\Jobs\SendTelegramNotification;
use App\Models\Categoria;
use App\Models\departamento;
use App\Models\edificio;
use App\Models\Equipo;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ActualizarTicket extends Component
{

    //Propiedades
    #[Reactive]
    public $ticketID;
    public $ticket;
    public $tema = "";
    public $descripcion = "";
    public $prioridad = "Baja";
    public $quien_reporta = "";
    public $telefono = "";
    public $edificio = "";
    public $departamento = "";
    public $ip = "";
    public $asignado = "";
    public $asignadoOld = "";
    public $categoria = "";
    public $autoriza = "";
    public $attachment = [];
    public $fecha_de_atencion;
    public $unidad;
    public $equipo;


    public function mount()
    {

        $this->ticket = Ticket::find($this->ticketID);
        $this->quien_reporta = $this->ticket->reporta;
        $this->telefono = $this->ticket->telefono;
        $this->edificio = $this->ticket->edificio;
        $this->departamento = $this->ticket->departamento;
        $this->ip = $this->ticket->ip;
        $this->autoriza = $this->ticket->autoriza;
        $this->categoria = $this->ticket->categoria;
        $this->asignado = $this->ticket->asignado;
        $this->asignadoOld = $this->ticket->asignado;
        $this->prioridad = $this->ticket->prioridad;
        $this->fecha_de_atencion = $this->ticket->fecha_atencion;
        $this->unidad = $this->ticket->unidad;

        $this->dispatch('buscarEquipo', ip: $this->ip)->to('HistorialTicket');
    }

    public function render()
    {
        $tecnicos = $this->getTecnicos();
        $categorias = $this->getCategorias();
        $edificios = $this->getEdificios();
        $departamentos = $this->getDepartamentos();

        return view('livewire.actualizar-ticket', compact('tecnicos', 'categorias', 'departamentos', 'edificios'));
    }


    function updatedIp()
    {

        $this->dispatch('buscarEquipo', ip: $this->ip)->to('HistorialTicket');
    }

    function getCategorias()
    {

        return Categoria::where('active', 1)
            ->orderBy('name')
            ->get();
    }

    function getEdificios()
    {

        return edificio::where('active', 1)
            ->orderBy('nombre')
            ->get();
    }

    function getDepartamentos()
    {

        return departamento::where('active', 1)
            ->orderBy('nombre')
            ->get();
    }

    function getTecnicos()
    {

        return User::where('activo', 1)
            ->where('tecnico', 1)
            ->orderBy('name')
            ->get();
    }

    function guardar()
    {
        //Validación
        $this->validate([
            'telefono' => 'required'
        ]);

        $ticketNew = Ticket::find($this->ticketID);
        $ticketNew->reporta = $this->quien_reporta;
        $ticketNew->asignado = ($this->asignado != "") ? $this->asignado : 0;
        $ticketNew->creador = Auth::user()->id;
        $ticketNew->prioridad = $this->prioridad;
        $ticketNew->categoria = $this->categoria;
        $ticketNew->telefono = $this->telefono;
        $ticketNew->departamento = $this->departamento;
        $ticketNew->edificio = $this->edificio;
        $ticketNew->ip = $this->ip;
        $ticketNew->autoriza = $this->autoriza;
        $ticketNew->usuario = Auth::user()->id;
        $ticketNew->fecha_atencion = $this->fecha_de_atencion;
        $ticketNew->unidad = $this->unidad;
        $ticketNew->save();

        //Comprobamos si se hizo cambio en la asignacion del ticket para mandar la notificacion
        if ($ticketNew->asignado != $this->asignadoOld) {
            SendTelegramNotification::dispatch($ticketNew->id);
        }

        //Registramos los cambios del ticket
        CambiosTicket::dispatch($this->ticket, $ticketNew);
        $this->dispatch('ticket-actualizado')->to(ComentariosTicket::class);
        $this->dispatch('alerta', msg: 'Cambios guardados!', type: 'success');
    }

    function limpiarEquipo()
    {

        $this->dispatch('limpiarEquipo')->to('HistorialTicket');
    }
}
