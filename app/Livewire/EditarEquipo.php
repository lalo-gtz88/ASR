<?php

namespace App\Livewire;

use App\Models\Equipo;
use App\Models\PC;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class EditarEquipo extends Component
{

    #[Reactive]
    public $uniqueId;
    public $tipo;
    public $serviceTag;

    function mount() {
        
        $e = Equipo::find($this->uniqueId);
        $this->serviceTag = $e->service_tag;
        $this->tipo = $e->tipo;
    }

    public function render()
    {
        return view('livewire.editar-equipo');
    }

}
