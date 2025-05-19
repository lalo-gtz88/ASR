<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Actividades extends Controller
{
    function index() {
        
        return view('actividades');

    }
}
