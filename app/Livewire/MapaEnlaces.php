<?php

namespace App\Livewire;

use App\Models\edificio;
use App\Models\Enlace;
use Livewire\Attributes\On;
use Livewire\Component;

class MapaEnlaces extends Component
{

    public $enlaces = [];
    public $sitios = [];
    public $sitio = "";
    

    function mount() {
        
        $this->getSitios();
    }

    public function render()
    {
        return view('livewire.mapa-enlaces');
    }

    #[On('obtenerEnlaces')]
    function getEnlaces() {
        
        if($this->sitio == "")
            $this->enlaces = Enlace::get();
        else{

            $this->enlaces = Enlace::where('sitio_id', $this->sitio)
            ->get();
        }

        $this->dispatch('enviarEnlaces', enlaces: $this->enlaces);
    }

    function getSitios()
    {

        $this->sitios = edificio::where('active', 1)->get();
    }
}
