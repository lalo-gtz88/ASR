<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RptUnidades extends Component
{
    public $inicio;
    public $termina;
    public $unidad;
    public $results = [];
    public $submitted;

    public function render()
    {
        return view('livewire.rpt-unidades');
    }

    public function getResults()
    {
        $this->validate([

            'inicio' => 'required',
            'termina' => 'required',
        ]);

        $statmentUnidad = ($this->unidad) ? "tickets.unidad LIKE '%" . $this->unidad . "%' AND" : "";

        $this->results = DB::select("SELECT tickets.id,
                                tickets.created_at as 'abierto',
                                tickets.departamento, 
                                tickets.categoria, 
                                tickets.unidad, 
                                tickets.edificio,
                                tickets.`status`,
                                tickets.categoria,
                                CONCAT_WS(' ', users.`name`, users.lastname) AS 'usuario', 
                                seguimientos.created_at as 'cerrado'
                                FROM tickets
                                LEFT JOIN seguimientos 
                                ON seguimientos.ticket = tickets.id AND seguimientos.notas = 'Status ha cambiado: Abierto -> Cerrado'
                                LEFT JOIN users
                                ON tickets.asignado = users.id
                                WHERE
                                {$statmentUnidad}
                                DATE(tickets.created_at) BETWEEN '" . Carbon::parse($this->inicio)->format('Y-m-d') . "' AND '" . Carbon::parse($this->termina)->format('Y-m-d') . "'
                                 ORDER BY tickets.id");

        $this->submitted = true;

        // $this->results = DB::select("SELECT tickets.id, seguimientos.created_at AS 'date', tickets.departamento, tickets.unidad, tickets.edificio, CONCAT_WS(' ', users.`name`, users.lastname) AS 'usuario' FROM tickets
        //                              JOIN seguimientos 
        //                              ON seguimientos.ticket = tickets.id
        //                              JOIN users
        //                              ON seguimientos.usuario = users.id
        //                              WHERE tickets.unidad LIKE '%" . $this->unidad . "%' and date(seguimientos.created_at) between '" . Carbon::parse($this->inicio)->format('Y-m-d') . "' AND '" . Carbon::parse($this->termina)->format('Y-m-d') . "' AND seguimientos.notas = 'Status ha cambiado: Abierto -> Cerrado';");

        //dd($this->results, $this->submitted);

    }
}
