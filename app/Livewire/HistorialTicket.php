<?php

namespace App\Livewire;

use App\Models\Equipo;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class HistorialTicket extends Component
{

    public $ticketID;
    public $equipo;
    public $uniqueId;

    protected $listeners = ['refrescar'=> '$refresh'];

    public function mount($id)
    {
        $this->uniqueId = now()->timestamp; // Valor para el key del componente ya que este valor es necesario para volver hidratar el componente (destruir y volver montarse) 
        $this->ticketID = $id;
    }

    public function render()
    {
        return view('livewire.historial-ticket');
    }


    #[On('buscarEquipo')]
    public function refrescar($ip) {
        
        $this->uniqueId = now()->timestamp; // Cambiar el valor para reiniciar comoponente
        $this->equipo = Equipo::where(DB::raw("INET_NTOA(direccion_ip)"), '=', '172.16.'.$ip )->first();
    }
}
