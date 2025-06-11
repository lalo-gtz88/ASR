<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ip extends Model
{
    use HasFactory;

    function relSegmento(): BelongsTo
    {

        return $this->belongsTo(Segmento::class, 'segmento_id');
    }

    function equipo(): BelongsTo
    {

        return $this->belongsTo(Equipo::class, 'equipo_id');
    }

    function usuario(): BelongsTo
    {

        return $this->belongsTo(User::class, 'user_id');
    }


    function getIconUsoAttribute()
    {

        if ($this->en_uso == 0)
            return '✅';
        else
            return '❌';
    }
}
