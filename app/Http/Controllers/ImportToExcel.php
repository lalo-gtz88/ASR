<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Imports\EqstockImport;
use Maatwebsite\Excel\Facades\Excel;


class ImportToExcel extends Controller
{
    function import(Request $request)
    {

        $request->validate([

            "almacenImp" => 'required',
            "fileXls" => 'required',
        ]);

        
        Excel::import(new EqstockImport($request->almacenImp), $request->file('fileXls'));
        return redirect(route('almacenes'));
    }
}
