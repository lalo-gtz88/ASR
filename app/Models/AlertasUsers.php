<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlertasUsers extends Model
{
    //

    protected $table ="alertas_users";
    protected $fillable = [
        'user_id',
        'categoria',
        'created_at',
        'updated_at',
    ];

    function relUser() : BelongsTo {
        
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
