<?php

namespace App\Livewire;

use App\Models\PC;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class PcDetails extends Component
{

    #[Reactive]
    public $uniqueId;
    public $ram;
    public $hdd;
    public $ssd;
    public $sistemaOperativo;
    public $usuario;
    public $usuarioRed;
    public $monitores;
    public $nombreDeEquipo;

    public function mount() {

        $pc = $this->getData($this->uniqueId);
        $this->ram = $pc->ram;
        $this->hdd = $pc->hdd;
        $this->ssd = $pc->sdd;
        $this->sistemaOperativo = $pc->sistema_operativo;
        $this->usuario = $pc->usuario;
        $this->usuarioRed = $pc->usuario_red;
        $this->monitores = $pc->monitores;
        $this->nombreDeEquipo = $pc->nombre_equipo;
    }

    public function render()
    {
        return view('livewire.pc-details');
    }

    function getData($id) {
        
        return PC::where('equipo_id', $id)->first();
    }

}
