<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Attributes\On;
use Livewire\Component;

class EditTicket extends Component
{
    public $ticketID;
    public $tema = "";
    public $descripcion = "";

    public function render()
    {
        return view('livewire.edit-ticket');
    }

    #[On('editar')]
    function setValores($id)
    {

        $ticket = Ticket::find($id);
        $this->ticketID = $id;
        $this->tema = $ticket->tema;
        $this->descripcion = $ticket->descripcion;
        $this->dispatch('showEditTicket', descripcion: $this->descripcion);
    }


    function save()
    {

        $this->validate([
            'tema' => 'required|max:255',
            'descripcion' => 'required',
        ]);

        $t = Ticket::find($this->ticketID);
        $t->tema = $this->tema;
        $t->descripcion = $this->descripcion;
        $t->save();

        //mandamos evento para actualizar en componente TicketsList
        $this->dispatch('ticket-saved')->to('TicketsList');
        //alerta de cambios guardados
        $this->dispatch('alerta', type: "success", msg: "Cambios guardados!");
        //cerramos modal
        $this->dispatch('cerrarModal');
        //limpiamos los campos
        $this->reset('tema', 'ticketID', 'descripcion');
    }
}
