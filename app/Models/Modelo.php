<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modelo extends Model
{
    /** @use HasFactory<\Database\Factories\ModeloFactory> */
    use HasFactory;

    protected $fillable = ['nombre', 'marca_id', 'foto'];


    function relMarca(): HasMany
    {
        return $this->hasMany(Marca::class, 'marca_id', 'id');
    }
}
