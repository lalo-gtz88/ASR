<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EqStock extends Model
{
    use HasFactory;

    protected $table = "eq_stock";

    protected $fillable = [
        'et',
        'tip',
        'not',
        'tip_id',
        'user_created_id',
        'condicion',
        'alm_id'
        
    ];
}
