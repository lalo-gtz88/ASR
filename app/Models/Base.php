<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Base extends Model
{
    use HasFactory;
    

    protected $table = "Base";

    function documentos(): HasMany
    {
    
        return $this->hasMany(BaseDoc::class, 'base_id');
       
    }

    function username() : BelongsTo {
        
        return $this->belongsTo(User::class, 'user_id');
    }

}
