<?php 

namespace App\Imports;

use App\Models\EqStock;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;

class FirstSheetImport implements OnEachRow
{

    private $almacen;

    public function __construct(int $almacen) 
    {
        $this->almacen = $almacen;
    }
    
    public function onRow(Row $row)
    {
        if($row->getIndex() == 1){
            
            return null;

        }else{

            $eq = new EqStock();
            $eq->et = $row[0];
            $eq->tip = $row[1];
            $eq->not = $row[2];
            $eq->tip_id = $row[3];
            $eq->condicion = $row[4];
            $eq->user_created_id = Auth::user()->id;
            $eq->alm_id = $this->almacen;
            $eq->save();

        }
    }
}