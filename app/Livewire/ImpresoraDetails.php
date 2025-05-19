<?php

namespace App\Livewire;

use App\Models\Printer;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ImpresoraDetails extends Component
{

    #[Reactive]
    public $uniqueId;
    public $aColor;
    public $multifuncional;
    public $proveedor;

    public function mount(){

        $p = $this->getData($this->uniqueId);
        $this->aColor = $p->color;
        $this->multifuncional = $p->multifuncional; 
        $this->proveedor = $p->proveedor;

    }

    public function render()
    {
        return view('livewire.impresora-details');
    }

    function getData($id) {
        
        return Printer::where('equipo_id', $id)->first();
    }
}
