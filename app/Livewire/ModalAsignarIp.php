<?php

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class ModalAsignarIp extends Component
{
    #[Reactive]
    public $ipToAssigned;

    public function render()
    {
        return view('livewire.modal-asignar-ip');
    }
}
