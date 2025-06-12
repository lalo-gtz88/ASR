<?php

namespace App\Observers;

use App\Models\Equipo;
use App\Models\Ip;

class EquipoObserver
{
    /**
     * Handle the Equipo "created" event.
     */
    public function created(Equipo $equipo): void
    {
        // Si al crear el equipo ya se le asignó una IP
        if ($equipo->direccion_ip) {
            $ip = Ip::where('ip', $equipo->direccion_ip)->first();
            if ($ip) {
                $ip->en_uso = true;
                $ip->save();
            }
        }
    }

    /**
     * Handle the Equipo "updated" event.
     */
    public function updated(Equipo $equipo): void
    {
        if ($equipo->wasChanged('direccion_ip')) {
            // Liberar IP anterior
            $ipAnterior = Ip::where('ip', $equipo->getOriginal('direccion_ip'))->first();
            if ($ipAnterior) {
                $ipAnterior->en_uso = false;
                $ipAnterior->save();
            }

            // Marcar nueva IP como en uso
            $ipNueva = Ip::where('ip', $equipo->direccion_ip)->first();
            if ($ipNueva) {
                $ipNueva->en_uso = true;
                $ipNueva->save();
            }
        }
    }

    /**
     * Handle the Equipo "deleted" event.
     */
    public function deleted(Equipo $equipo): void
    {
        //
    }

    /**
     * Handle the Equipo "restored" event.
     */
    public function restored(Equipo $equipo): void
    {
        //
    }

    /**
     * Handle the Equipo "force deleted" event.
     */
    public function forceDeleted(Equipo $equipo): void
    {
        //
    }
}
