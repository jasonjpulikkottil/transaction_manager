<?php

namespace App\Imports;

use App\Models\StockTemp;
use Maatwebsite\Excel\Concerns\ToModel;

class StockTempImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
    
        return new StockTemp([
            'no'     => $row[0],
            'description'    => $row[1], 
            'qty' => $row[2],
            'barcode' => $row[3],


        ]);
    }
}
