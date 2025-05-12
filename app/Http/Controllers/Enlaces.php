<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Enlaces extends Controller
{
    function index()  {
        
        return view('enlaces');
    }
}
