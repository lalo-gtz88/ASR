<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    /** @use HasFactory<\Database\Factories\PrinterFactory> */
    use HasFactory;

    protected $fillable = ['equipo_id', 'multifuncional', 'color', 'proveedor'];
}
