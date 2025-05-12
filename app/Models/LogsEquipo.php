<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogsEquipo extends Model
{
    use HasFactory;

    function relEquipo(): BelongsTo {
        
        return $this->belongsTo(Equipo::class,'equipo_id');
    }

    function relUser(): BelongsTo {
        
        return $this->belongsTo(User::class,'usuario_id');
    }

    
}
