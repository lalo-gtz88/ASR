<?php

namespace App\Livewire;

use App\Models\Enlace;
use Livewire\Component;

class Enlaces extends Component
{

    public $buscar="";

    protected $listeners = ['eliminar'];

    public function render()
    {

        $enlaces = $this->getEnlaces();

        return view('livewire.enlaces', compact('enlaces'));
    }

    public function getEnlaces() {
        
        return Enlace::where('descripcion', 'LIKE', '%'.$this->buscar.'%')
        ->orWhere('referencia', 'LIKE', '%'.$this->buscar.'%')
        ->get();
    }

}
