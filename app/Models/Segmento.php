<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Segmento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'subred_inicio',
        'subred_fin',
        'mascara',
        'hosts_disponibles'
    ];


    function relEdificio(): BelongsTo
    {

        return $this->belongsTo(edificio::class, 'edificio_id', 'id');
    }
}
