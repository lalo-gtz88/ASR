<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PC extends Model
{
    /** @use HasFactory<\Database\Factories\PCFactory> */
    use HasFactory;

    protected $table= "pcs";
    
    protected $fillable = ['equipo_id', 'ram', 'hdd', 'sdd', 'sistema_operativo', 'usuario', 'usuario_red', 'monitores'];

    function relEquipo(): HasOne{
        
        return $this->hasOne('Equipo','equipo_id', 'id');

    }
}
