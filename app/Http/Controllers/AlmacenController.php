<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    function index() {
        
        return view('almacen-view');
    }
}
