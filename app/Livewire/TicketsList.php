<?php

namespace App\Livewire;

use App\Events\CambiosTicket;
use App\Models\Categoria;
use App\Models\departamento;
use App\Models\edificio;
use App\Models\Ticket;
use App\Models\User;
use Livewire\Attributes\On;
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

        $tickets = $this->getTickets();

        $tecnicos = $this->getTecnicos();

        $this->obtenerSeguimientos();


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
            ->where('asignado', 'LIKE', '%' . $this->fu . '%')
            ->where('status', $this->fst)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);;
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
        $this->dispatch('alerta',  type:"success", msg: 'Registro eliminado!');
    }

    function asignar($ticketID, $tecnicoID){

        $t = Ticket::find($ticketID);
        $t->asignado = $tecnicoID;
        $t->save();

        $this->dispatch('alerta',  type:"success", msg: 'Ticket asignado!');

    }

    function obtenerSeguimientos()  {
        
        // $ticket = Ticket::find(14);
        // dd($ticket->seguimientos);
    }

}
