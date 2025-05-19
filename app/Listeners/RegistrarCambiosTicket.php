<?php

namespace App\Listeners;

use App\Events\CambiosTicket;
use App\Models\Seguimiento;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class RegistrarCambiosTicket
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CambiosTicket $event): void
    {

        $tO = $event->ticketOld;
        $tN = $event->ticketNew;

        $mensajes = [];

        if ($tO->tema != $tN->tema) {
            array_push($mensajes, [
                "comentario" =>  "Tema ha cambiado: " . $tO->tema . " -> " . $tN->tema,
                "usuario" => Auth::user()->id
            ]);
        }

        if ($tO->descripcion != $tN->descripcion) {
            array_push($mensajes, [
                "comentario" =>  "Descripción ha cambiado: " . $tO->descripcion . " -> " . $tN->descripcion,
                "usuario" => Auth::user()->id
            ]);
        }

        if ($tO->telefono != $tN->telefono) {
            array_push($mensajes, [
                "comentario" =>  "Teléfono ha cambiado: " . $tO->telefono . " -> " . $tN->telefono,
                "usuario" => Auth::user()->id
            ]);
        }

        if ($tO->departamento != $tN->departamento) {
            array_push($mensajes, [
                "comentario" =>  "Departamento ha cambiado: " . $tO->departamento . " -> " . $tN->departamento,
                "usuario" => Auth::user()->id
            ]);
        }

        if ($tO->ip != $tN->ip) {
            array_push($mensajes, [
                "comentario" =>  "Ip ha cambiado: " . $tO->ip . " -> " . $tN->ip,
                "usuario" => Auth::user()->id
            ]);
        }

        if ($tO->asignado != $tN->asignado) {
            if ($tO->asignado != 0 && $tN->asignado != 0) {
                array_push($mensajes, [
                    "comentario" =>  "La asignacion de ticket ha cambiado: " . $tO->tecnico->name . ' ' . $tO->tecnico->lastname  . " -> " . $tN->tecnico->name . ' ' . $tN->tecnico->lastname,
                    "usuario" => Auth::user()->id
                ]);
            }else{
                if ($tO->asignado == 0){
                    array_push($mensajes, [
                        "comentario" =>  "Ticket se ha asignado: -> " . $tN->tecnico->name . ' ' . $tN->tecnico->lastname,
                        "usuario" => Auth::user()->id
                    ]);
                }

                if($tN->asignado == 0){
                    array_push($mensajes, [
                        "comentario" =>  "La asignacion de ticket ha cambiado: " . $tO->tecnico->name . ' ' . $tO->tecnico->lastname  . " -> ",
                        "usuario" => Auth::user()->id
                    ]);
                }
            }
        }

        if ($tO->edificio != $tN->edificio) {
            array_push($mensajes, [
                "comentario" =>  "Edificio ha cambiado: " . $tO->edificio . " -> " . $tN->edificio,
                "usuario" => Auth::user()->id
            ]);
        }

        if ($tO->usuario_red != $tN->usuario_red) {
            array_push($mensajes, [
                "comentario" =>  "El usuario de red ha cambiado: " . $tO->usuario_red . " -> " . $tN->usuario_red,
                "usuario" => Auth::user()->id
            ]);
        }

        if ($tO->autoriza != $tN->autoriza) {
            array_push($mensajes, [
                "comentario" =>  "Quine autoriza ha cambiado: " . $tO->autoriza . " -> " . $tN->autoriza,
                "usuario" => Auth::user()->id
            ]);
        }

        if ($tO->prioridad != $tN->prioridad) {
            array_push($mensajes, [
                "comentario" =>  "Prioridad ha cambiado: " . $tO->prioridad . " -> " . $tN->prioridad,
                "usuario" => Auth::user()->id
            ]);
        }

        if ($tO->categoria != $tN->categoria) {
            array_push($mensajes, [
                "comentario" =>  "Categoría ha cambiado: " . $tO->categoria . " -> " . $tN->categoria,
                "usuario" => Auth::user()->id
            ]);
        }

        if ($tO->status != $tN->status) {
            array_push($mensajes, [
                "comentario" =>  "Status ha cambiado: " . $tO->status . " -> " . $tN->status,
                "usuario" => Auth::user()->id
            ]);
        }

        if ($tO->reporta != $tN->reporta) {
            array_push($mensajes, [
                "comentario" =>  "Usuario ha cambiado: " . $tO->reporta . " -> " . $tN->reporta,
                "usuario" => Auth::user()->id
            ]);
        }

        if ($tO->fecha_atencion != $tN->fecha_atencion) {
            array_push($mensajes, [
                "comentario" =>  "La fecha de atención ha cambiado: " . Carbon::parse($tO->fecha_atencion)->format('d/m/Y') . " -> " . Carbon::parse($tN->fecha_atencion)->format('d/m/Y'),
                "usuario" => Auth::user()->id
            ]);
        }

        if ($tO->unidad != $tN->unidad) {
            array_push($mensajes, [
                "comentario" =>  "Unidad ha cambiado: " . $tO->unidad . " -> " . $tN->unidad,
                "usuario" => Auth::user()->id
            ]);
        }

        foreach ($mensajes as $mensaje) {

            $comentario = new Seguimiento();
            $comentario->notas = $mensaje["comentario"];
            $comentario->ticket = $tN->id;
            $comentario->usuario = $mensaje["usuario"];
            $comentario->save();
        }
    }
}
