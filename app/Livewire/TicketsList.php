<?php

namespace App\Livewire;

use App\Events\CambiosTicket;
use App\Jobs\SendTelegramNotification;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TicketsList extends Component
{

    use WithPagination;

    #[Url(history: true)]
    public $search;
    #[Url(history: true)]
    public $fs = "id";
    #[Url(history: true)]
    public $fu = "";
    #[Url(history: true)]
    public $fst = "ABIERTO";

    public $ticketID;

    protected $paginationTheme = 'bootstrap'; //para usar la paginacion de livewire con bootstrap 
    protected $listeners = ['ticket-saved' => '$refresh'];

    public function render()
    {
        $tecnicos = $this->getTecnicos();


        $user = User::find(Auth::user()->id);

        //si el usuario no tiene privilegio de ver todos los tickets 
        if (!$user->can('Mostrar todos los tickets')) {

            $this->fu = $user->id;
            $this->fu = Auth::user()->id;
            $this->dispatch('disabledFiltro');
        }

        $tickets = $this->getTickets();
        //$this->obtenerSeguimientos();

        return view('livewire.tickets-list', compact('tickets', 'tecnicos'));
    }

    function updatingSearch()
    {
        $this->resetPage();
    }

    function updatedFiltroStatus()
    {

        $this->resetPage();
    }

    function updatedFiltroUsuario()
    {

        $this->resetPage();
    }

    function getTickets()
    {

        return Ticket::where('active', 1)
            ->where($this->fs, 'LIKE', '%' . $this->search . '%')
            ->when(is_numeric($this->fu), fn($q) => $q->where('asignado', $this->fu))
            ->where('status', $this->fst)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
    }

    function getTecnicos()
    {

        return User::where('activo', 1)
            ->where('tecnico', 1)
            ->orderBy('name')
            ->get();
    }

    function delete($id)
    {

        Ticket::find($id)->delete();
        $this->dispatch('ticket-saved')->to(CajaEstadistica::class);
        $this->dispatch('alerta',  type: "success", msg: 'Registro eliminado!');
    }

    function asignar($ticketID, $tecnicoID)
    {

        $ticket = Ticket::find($ticketID);

        $ticketOld = clone $ticket;

        $ticket->asignado = $tecnicoID;
        $ticket->save();


        $this->dispatch('alerta',  type: "success", msg: 'Ticket asignado!');

        //registramos loscambios en el ticket
        CambiosTicket::dispatch($ticketOld, $ticket);

        //enviamos notificacion por telegram
        SendTelegramNotification::dispatch($ticket->id);
    }
}
