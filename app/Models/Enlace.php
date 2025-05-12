<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enlace extends Model
{
    /** @use HasFactory<\Database\Factories\EnlaceFactory> */
    use HasFactory;

    function relProveedor() : BelongsTo {
        
        return $this->belongsTo(Proveedor::class, 'proveedor_id', 'id');
    }

    function relSitio() : BelongsTo {

        return $this->belongsTo(edificio::class, 'sitio_id', 'id');
    }
}
