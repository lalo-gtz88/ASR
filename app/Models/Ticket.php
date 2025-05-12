<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'tema',
        'descripcion',
        'telefono',
        'departamento',
        'ip',
        'asignado',
        'edificio',
        'usuario_red',
        'autoriza',
        'creador',
        'prioridad',
        'colorPrioridad',
        'categoria',
        'status',
        'usuario',
        'reporta',
        'fecha_atencion'
    ];


    function tecnico() : HasOne {
        
        return $this->hasOne(User::class , 'id', 'asignado');
        
    }

    function userCreador() : HasOne{
        
        return $this->HasOne(User::class,'id', 'creador');
    }

    function seguimientos(): HasMany{
        
        return $this->hasMany(Seguimiento::class, 'ticket', 'id');
    }
}
