<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipoController extends Controller
{
    function index($id)
    {

        $uniqueId = $id;
        return view('equipo-detalles', compact('uniqueId'));
    }

    function create($ip = null)
    {
        return view('nuevo-equipo', ['ip' => $ip]);
    }


    function edit($id)
    {

        $uniqueId = $id;
        return view('equipo-editar', compact('uniqueId'));
    }
}
