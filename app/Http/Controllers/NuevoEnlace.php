<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NuevoEnlace extends Controller
{

    function index()  {
        
        return view('nuevo-enlace');
    }
}
