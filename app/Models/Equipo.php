<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipo extends Model
{
    /** @use HasFactory<\Database\Factories\EquipoFactory> */
    use HasFactory;


    protected $fillable = ['service_tag', 'tipo', 'inventario', 'fecha_adquisicion', 'marca', 'modelo', 'direccion_ip', 'direccion_mac'];


    function relTipoEquipo(): BelongsTo
    {

        return $this->belongsTo(TiposEquipo::class, 'tipo');
    }

    function relMarca(): BelongsTo
    {

        return $this->belongsTo(Marca::class, 'marca');
    }

    function relModelo(): BelongsTo
    {

        return $this->belongsTo(Modelo::class, 'modelo');
    }

    public function historial()
    {
        return $this->hasMany(EquipoHistorial::class);
    }
}
