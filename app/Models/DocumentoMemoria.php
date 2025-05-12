<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DocumentoMemoria extends Model
{
    /** @use HasFactory<\Database\Factories\DocumentoMemoriaFactory> */
    use HasFactory;

    protected $table = "documentos_memorias";

    protected $fillable = ['memoria_id', 'documento'];

    function relMemoria() : HasMany {
        
        return $this->hasMany(MemoriaTecnica::class, 'memoria_id', 'id');
    }
}
