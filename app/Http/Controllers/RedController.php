<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedController extends Controller
{
    function indexIps()
    {

        return view('red-ips');
    }
}
