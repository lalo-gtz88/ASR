<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogosController extends Controller
{
    public function index($tipo)
    {
        return view('catalogos', ['tipo' => $tipo]);
    }
}
