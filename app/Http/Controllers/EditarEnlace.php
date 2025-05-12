<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditarEnlace extends Controller
{
    public function index($id) {
        
        $uniqueId = $id;
        return view('editar-enlace', compact('uniqueId'));
    }
}
