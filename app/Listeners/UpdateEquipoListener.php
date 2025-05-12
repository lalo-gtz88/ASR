<?php

namespace App\Listeners;

use App\Events\UpdateEquipoEvent;
use App\Models\Ip;
use App\Models\LogsEquipo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateEquipoListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UpdateEquipoEvent $event)
    {
        if ($event->ipasigned != null) {

            $ip = Ip::select(DB::raw('INET_NTOA(direccion) as dir'))
                ->whereRelation('equipo', 'equipo_id', $event->equipoOld->id)->first();

            if ($event->ipasigned == 'asignada') 
                $text = "Se ha asignado la ip {$ip->dir} al equipo";
            else 
                $text = "Se ha liberado ip del equipo";

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = $text;
            $l->save();

        }

        if ($event->equipoOld->descripcion != $event->equipoNew->descripcion) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "Descripcion: {$event->equipoOld->descripcion} -> {$event->equipoNew->descripcion}";
            $l->save();
        }

        if ($event->equipoOld->tipo != $event->equipoNew->tipo) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "Tipo: {$event->equipoOld->tipo} -> {$event->equipoNew->tipo}";
            $l->save();
        }

        if ($event->equipoOld->marca != $event->equipoNew->marca) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "Marca: {$event->equipoOld->marca} -> {$event->equipoNew->marca}";
            $l->save();
        }

        if ($event->equipoOld->modelo != $event->equipoNew->modelo) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "Modelo: {$event->equipoOld->modelo} -> {$event->equipoNew->modelo}";
            $l->save();
        }


        if ($event->equipoOld->cuenta_local != $event->equipoNew->cuenta_local) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "Cuenta local: {$event->equipoOld->cuenta_local} -> {$event->equipoNew->cuenta_local}";
            $l->save();
        }

        if ($event->equipoOld->nombre != $event->equipoNew->nombre) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "Nombre: {$event->equipoOld->nombre} -> {$event->equipoNew->nombre}";
            $l->save();
        }

        if ($event->equipoOld->dsi != $event->equipoNew->dsi) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "DSI: {$event->equipoOld->dsi} -> {$event->equipoNew->dsi}";
            $l->save();
        }

        if ($event->equipoOld->usuario != $event->equipoNew->usuario) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "Usuario: {$event->equipoOld->usuario} -> {$event->equipoNew->usuario}";
            $l->save();
        }

        if ($event->equipoOld->ram != $event->equipoNew->ram) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "RAM: {$event->equipoOld->ram} GB -> {$event->equipoNew->ram} GB";
            $l->save();
        }

        if ($event->equipoOld->hdd != $event->equipoNew->hdd) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "HDD: {$event->equipoOld->hdd} {$event->equipoOld->unidadHdd}  -> {$event->equipoNew->hdd}{$event->equipoOld->unidadHdd}";
            $l->save();
        }


        if ($event->equipoOld->ssd != $event->equipoNew->ssd) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "SSD: {$event->equipoOld->ssd} {$event->equipoOld->unidadSsd} -> {$event->equipoNew->ssd} {$event->equipoOld->unidadSsd}";
            $l->save();
        }

        if ($event->equipoOld->procesador != $event->equipoNew->procesador) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "Procesador: {$event->equipoOld->procesador} -> {$event->equipoNew->procesador}";
            $l->save();
        }

        if ($event->equipoOld->departamento != $event->equipoNew->departamento) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "Departamento: {$event->equipoOld->departamento} -> {$event->equipoNew->departamento}";
            $l->save();
        }

        if ($event->equipoOld->so != $event->equipoNew->so) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "Sistema Operativo: {$event->equipoOld->so} -> {$event->equipoNew->so}";
            $l->save();
        }

        if ($event->equipoOld->user_dominio != $event->equipoNew->user_dominio) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "Usuario de dominio: {$event->equipoOld->user_dominio} -> {$event->equipoNew->user_dominio}";
            $l->save();
        }

        if ($event->equipoOld->mac_address != $event->equipoNew->mac_address) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "Dirección MAC: {$event->equipoOld->mac_address} -> {$event->equipoNew->mac_address}";
            $l->save();
        }

        if ($event->equipoOld->comentarios != $event->equipoNew->comentarios) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "Comentarios: {$event->equipoOld->comentarios} -> {$event->equipoNew->comentarios}";
            $l->save();
        }

        if ($event->equipoOld->nodo != $event->equipoNew->nodo) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $l->desc = "Nodo: {$event->equipoOld->nodo} -> {$event->equipoNew->nodo}";
            $l->save();
        }

        if ($event->equipoOld->programas != $event->equipoNew->programas) {

            $l = new LogsEquipo();
            $l->equipo_id = $event->equipoOld->id;
            $l->usuario_id = Auth::user()->id;
            $pold = str_replace("\n", ", ", trim($event->equipoOld->programas));
            $pnew = str_replace("\n", ", ", trim($event->equipoNew->programas));
            $l->desc = "Programas: {$pold} -> {$pnew}";
            $l->save();
        }



        //Log::channel('single')->info("{$event->equipoOld->service_tag} ha cambiado Nombre: {$event->equipoOld->nombre} -> {$event->equipoNew->nombre}");

        // if($event->equipoOld->dsi != $event->equipoNew->dsi)
        //     Log::channel('single')->info("{$event->equipoOld->service_tag} ha cambiado DSI: {$event->equipoOld->dsi} -> {$event->equipoNew->dsi}");

        // if($event->equipoOld->usuario != $event->equipoNew->usuario)
        //     Log::channel('single')->info("{$event->equipoOld->service_tag} ha cambiado Usuario: {$event->equipoOld->usuario} -> {$event->equipoNew->usuario}");
    }
}
