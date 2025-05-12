<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Monitoreo extends Model
{
    
    protected $table = "monitoreo";

    function relDispositivo() : BelongsTo {
        
        return $this->belongsTo(Equipo::class, 'dispositivo', 'id');
    }
}
