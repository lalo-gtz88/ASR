<?php

namespace App\Imports;

use App\Models\EqStock;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Row;

class EqstockImport implements WithMultipleSheets
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public $almacen;

    public function __construct($almacen)
    {
        $this->almacen = $almacen;
    }

    public function sheets() : array {
        
        return [

            0 => new FirstSheetImport($this->almacen)
        ];
    }

}