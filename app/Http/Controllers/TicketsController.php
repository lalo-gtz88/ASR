<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketsController extends Controller
{


    function newTicket() {
        
        return view('new-ticket');
    }

    function copy($id) {
        
        $uniqueId = $id;
        return view('copy-ticket', compact('uniqueId'));
        
    }
}
