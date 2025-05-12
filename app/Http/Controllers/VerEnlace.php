<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerEnlace extends Controller
{

    public function index($id){

        $uniqueId = $id;
        return view('ver-enlace', compact('uniqueId'));
    }
    
}
