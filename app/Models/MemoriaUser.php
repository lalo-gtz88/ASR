<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemoriaUser extends Model
{
    /** @use HasFactory<\Database\Factories\MemoriaUserFactory> */
    use HasFactory;
    protected $table = "memorias_users";
    protected $fillable = ['user_id', 'memoria_id'];
}
