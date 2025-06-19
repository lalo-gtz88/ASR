<?php

namespace App\Observers;

use App\Models\Equipo;
use App\Models\EquipoHistorial;
use App\Models\Ip;
use Illuminate\Support\Facades\Auth;

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

        // Verifica campos que cambian
        foreach ($equipo->getDirty() as $campo => $nuevoValor) {

            //evitamos que guarde los cambios de los timestamp
            if (in_array($campo, ['created_at', 'updated_at'])) {
                continue;
            };

            $valorAnterior = $equipo->getOriginal($campo);

            // Detectamos si es un campo de relación (catálogo)
            switch ($campo) {
                case 'tipo':
                    $valorAnterior = optional(\App\Models\TiposEquipo::find($valorAnterior))->nombre;
                    $nuevoValor = optional(\App\Models\TiposEquipo::find($nuevoValor))->nombre;
                    break;
                case 'marca':
                    $valorAnterior = optional(\App\Models\Marca::find($valorAnterior))->nombre;
                    $nuevoValor = optional(\App\Models\Marca::find($nuevoValor))->nombre;
                    break;
                case 'modelo':
                    $valorAnterior = optional(\App\Models\Modelo::find($valorAnterior))->nombre;
                    $nuevoValor = optional(\App\Models\Modelo::find($nuevoValor))->nombre;
                    break;
                case 'direccion_ip':
                    $valorAnterior =  optional(\App\Models\Ip::where('ip', $valorAnterior))->first()->ip;
                    $valorAnterior = long2ip($valorAnterior);
                    $nuevoValor = optional(\App\Models\Ip::where('ip', $nuevoValor))->first()->ip;
                    $nuevoValor = long2ip($nuevoValor);
                    break;
            }

            EquipoHistorial::create([
                'equipo_id' => $equipo->id,
                'campo' => $campo,
                'valor_anterior' => $valorAnterior,
                'valor_nuevo' => $nuevoValor,
                'usuario_id' => Auth::id(), // puede ser null si se ejecuta desde consola
            ]);
        }

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
