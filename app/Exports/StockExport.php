<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;

class StockExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    

    public function collection()
    {
        return Stock::select("no", "description", "qty","barcode")->get();
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["no", "description", "qty","barcode"];
    }
}
