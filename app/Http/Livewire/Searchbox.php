<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Stock;

class Searchbox extends Component
{
     public $showdiv = false;
     public $searchproduct = "";
     public $searchbar = "";
     public $searchqty = 1;
     
     public $records;
     
     public $stockDetails;

     // Fetch records
     public function searchResult(){

         if(!empty($this->searchproduct)){

             $this->records = Stock::orderby('no','asc')
                       ->select('*')
                       ->where('description','like','%'.$this->searchproduct.'%')
                       ->limit(5)
                       ->get();

             $this->showdiv = true;
         }else{
             $this->showdiv = false;
         }
     }
     public function searchResult2()
    {

        if (!empty($this->searchbar)) {

            
            $inputString = $this->searchbar;
            $numSlashes = substr_count($inputString, '/');
           
            if ($numSlashes >= 6) {
                $splittedString = explode('/', $inputString);
                $var1 = str_replace(' ', '', $splittedString[3]);
                $var2 = ltrim(trim($splittedString[4]), '0');
               // $var3 = $splittedString[5];
                $this->searchproduct= $var1 ;
                $this->searchqty= $var2 ;
                
               
            }






            /*

            $this->searchproduct= Stock::orderby('no','asc')
                      ->select('*')
                      ->where('barcode','=' ,$this->searchbar)
                      ->limit(1)
                      ->value('description');
          */
        }
    }


public function searchempty()
{
    
      //  sleep(2); // Wait for 2 seconds
      //  $this->searchproduct =  $this->searchproduct . " ";
       // $this->searchbar = "";
       // $this->searchqty = 0;
    
        
      
    
}

     // Fetch record by ID
     public function fetchStockDetail($no = 1){

         $record =Stock::select('*')->where('no',$no)->first();
                     

                     $this->searchproduct = $record->description;
                     $this->searchbar = $record->barcode;
                    
         $this->stockDetails = $record;
         $this->showdiv = false;
     }

     public function render(){ 
         return view('livewire.searchbox');
     }
}