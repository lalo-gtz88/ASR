<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipoHistorial extends Model
{
    protected $table = "equipos_historial";

    protected $fillable = [
        'equipo_id',
        'campo',
        'valor_anterior',
        'valor_nuevo',
        'usuario_id',
    ];

    function relMarca(): BelongsTo
    {

        return $this->belongsTo(Marca::class, 'valor_anterior');
    }

    function relUser(): BelongsTo
    {

        return $this->belongsTo(User::class, 'usuario_id');
    }
}
