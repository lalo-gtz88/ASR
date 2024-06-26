<?php

namespace App\Http\Livewire;

use App\Models\VTicketsAsignados;
use App\Models\VTicketsEdificio;
use Livewire\Component;

class Charts extends Component
{
    protected $listeners = ['renderCharts'];

    public function render()
    {
        return view('livewire.charts');
    }

    public function renderCharts()
    {
        $labelsBar1 = [];
        $datosBar1 = [];
        $datosBar2 = [];

        $labelsPie = [];
        $datosPie = [];

        //Consulta para tickets asignados
        $results = VTicketsAsignados::get();

        foreach ($results as $result) {

            array_push($labelsBar1, $result->asignado);
            array_push($datosBar1, $result->abiertos);
            array_push($datosBar2, $result->pendientes);
        }

        
        $results = VTicketsEdificio::get();

        ////Consulta para tickets x edificios
        // $results = VTickets::select(DB::raw('count(edificio) as num, edificio'))
        //     ->groupBy('edificio')->get();

        foreach ($results as $result) {
            array_push($labelsPie, $result->edificio);
            array_push($datosPie, $result->num_tickets);
        }

        $this->dispatchBrowserEvent('loadCharts', [
            'labels' => $labelsBar1,
            'datosOpen' => $datosBar1,
            'datosPendientes' => $datosBar2,
            'labelsEdificio' => $labelsPie,
            'datosEdificios' => $datosPie,
        ]);
    }
}
