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
    function setValores($id) {
    
        $ticket = Ticket::find($id);
        $this->ticketID = $id;
        $this->tema = $ticket->tema;
        $this->descripcion = $ticket->descripcion;
        $this->dispatch('setDesc', descripcion: $this->descripcion);
        $this->dispatch('showEditTicket', descripcion: $this->descripcion);
    }


    function save() {
        
        $this->validate([
            'tema' => 'required|max:255',
        ]);

        if($this->descripcion == '<br>' || $this->descripcion == '<p><br></p>' || $this->descripcion == ''){
            
            $this->addError('descEmpty' ,"El campo descripción debe completarse");
            return;

        }

        $t = Ticket::find($this->ticketID);
        $t->tema = $this->tema;
        $t->descripcion = $this->descripcion;
        $t->save();

        $this->dispatch('alerta', type:"success", msg:"Cambios guardados!" );
        
    }

}
