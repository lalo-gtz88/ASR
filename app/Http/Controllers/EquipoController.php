<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipoController extends Controller
{
    function index($id)  {
        
        $uniqueId = $id;
        return view('equipo-detalles', compact('uniqueId'));
    }

    function create() {
        
        return view('nuevo-equipo');
    }


    function edit($id) {
        
        $uniqueId = $id;
        return view('equipo-editar', compact('uniqueId'));

    }
}
