<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemoriaTecnica extends Model
{
    /** @use HasFactory<\Database\Factories\MemoriaTecnicaFactory> */
    use HasFactory;

    protected $table = "memorias_tecnicas";

    protected $fillable = ['user_id', 'nombre', 'created_at', 'updated_at' ];


    //Accesors
    function getFechaDeCreacionAttribute()  {
        
        return Carbon::parse($this->created_at)->format('d/m/Y H:i:s');
    }

    function getCapitalNameAttribute()  {
        
        return ucfirst($this->nombre);
    }

    //Relaciones
    function relUser() : BelongsTo{
        
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
