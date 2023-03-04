<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StockImport;
use App\Imports\StockTempImport;
use App\Exports\StockExport;
use App\Models\StockTemp;
use App\Models\TransactionHistory;

use DB;
use LDAP\Result;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function StockController()
    {   /*
        Stock::truncate();
        TransactionHistory::truncate();
        */
        //$stock = DB::table('stock')->get();

        $stock = Stock::simplePaginate(10);

        return view("admin-dashboard/stock")->with('stock', $stock);
    }

    public function PurchaseController()
    {

        return view("admin-dashboard/purchase");
    }

    public function SalesController()
    {


        // $stock = DB::table('stock')->get();

        $stock = Stock::simplePaginate(10);
        return view("admin-dashboard/sales")->with('stock', $stock);
    }

    public function PurchaseReturnController()
    {

        return view("admin-dashboard/purchase-return");
    }

    public function SalesReturnController()
    {

        return view("admin-dashboard/sales-return");
    }

    public function TransactionHistoryController()
    {


        //$trn = DB::table('transactionhistory')->get();
        //$trn = TransactionHistory::simplePaginate(10);

        $trn = TransactionHistory::orderBy('no', 'desc')->simplePaginate(10);

        return view("admin-dashboard/transaction-history")->with('trn', $trn);;
    }

    public function StockUpload(Request $request)
    {


        Stock::truncate();
        Excel::import(new StockImport, request()->file('stockfile'));


        $stock = DB::table('stock')->get();
        $currentDate = Carbon::today();
        $currentTime = Carbon::now()->format('H:i:s');


        $stocktemp = DB::table('stocktemp')->get();

        foreach ($stock as $order) {


            DB::table('transactionhistory')->insert([


                'trans_date' => $currentDate,
                'trans_time' => $currentTime,
                'description' => $order->description,
                'qty' => $order->qty,
                'info' => "Stock Updated"
            ]);
        }

        $stock = Stock::simplePaginate(10);


        return view("admin-dashboard/stock")->with(['stock' => $stock]);
    }

    public function StockExport()
    {
        return Excel::download(new StockExport, 'stock.csv');

        $stock = DB::table('stock')->get();
        return view("admin-dashboard/stock")->with(['stock' => $stock]);
    }



    public function SalesUpload(Request $request)
    {


        StockTemp::truncate();

        Excel::import(new StockTempImport, request()->file('salesfile'));


        $stock = DB::table('stock')->get();
        $stocktemp = DB::table('stocktemp')->get();



        foreach ($stocktemp as $order) {
            $stock2 = DB::table('stock')->where('description', $order->description)->first();
            if ($stock2->qty >= $order->qty) {
                DB::table('stock')->where('description', $order->description)->decrement('qty', $order->qty);
            }
        }
        DB::table('stock')->where('qty', '<=', 0)->delete();

        $stock = DB::table('stock')->get();


        $currentDate = Carbon::today();
        $currentTime = Carbon::now()->format('H:i:s');


        $stocktemp = DB::table('stocktemp')->get();

        foreach ($stocktemp as $order) {


            DB::table('transactionhistory')->insert([


                'trans_date' => $currentDate,
                'trans_time' => $currentTime,
                'description' => $order->description,
                'qty' => $order->qty,
                'info' => "Sales Data Subtracted"
            ]);
        }

        return view("admin-dashboard/stock")->with(['stock' => $stock, 'stocktemp' => $stocktemp]);
    }


    public function PurchaseUpload(Request $request)
    {


        StockTemp::truncate();

        Excel::import(new StockTempImport, request()->file('purchasefile'));


        $stock = DB::table('stock')->get();
        $stocktemp = DB::table('stocktemp')->get();



        foreach ($stocktemp as $order) {
            $stock2 = DB::table('stock')->where('description', $order->description)->first();

            DB::table('stock')->where('description', $order->description)->increment('qty', $order->qty);

            $result = DB::table('stock')
                ->where('description', $order->description)
                ->exists();
            if (!$result) {
                DB::table('stock')->insert([
                    'no' => $order->no,
                    'description' => $order->description,
                    'qty' => $order->qty,
                    'barcode' => $order->barcode,


                ]);
            }
        }



        $stock = DB::table('stock')->get();



        $currentDate = Carbon::today();
        $currentTime = Carbon::now()->format('H:i:s');


        $stocktemp = DB::table('stocktemp')->get();

        foreach ($stocktemp as $order) {


            DB::table('transactionhistory')->insert([


                'trans_date' => $currentDate,
                'trans_time' => $currentTime,
                'description' => $order->description,
                'qty' => $order->qty,
                'info' => "Purchase Data Added"
            ]);
        }

        return view("admin-dashboard/stock")->with(['stock' => $stock, 'stocktemp' => $stocktemp]);
    }



    public function PurchaseReturnUpload(Request $request)
    {


        StockTemp::truncate();

        Excel::import(new StockTempImport, request()->file('purchasereturnfile'));


        $stock = DB::table('stock')->get();
        $stocktemp = DB::table('stocktemp')->get();



        foreach ($stocktemp as $order) {
            $stock2 = DB::table('stock')->where('description', $order->description)->first();
            if ($stock2->qty >= $order->qty) {
                DB::table('stock')->where('description', $order->description)->decrement('qty', $order->qty);
            }
        }
        DB::table('stock')->where('qty', '<=', 0)->delete();

        $stock = DB::table('stock')->get();



        $currentDate = Carbon::today();
        $currentTime = Carbon::now()->format('H:i:s');


        $stocktemp = DB::table('stocktemp')->get();

        foreach ($stocktemp as $order) {


            DB::table('transactionhistory')->insert([


                'trans_date' => $currentDate,
                'trans_time' => $currentTime,
                'description' => $order->description,
                'qty' => $order->qty,
                'info' => "Purchase Return Data Subtracted"
            ]);
        }

        return view("admin-dashboard/stock")->with(['stock' => $stock, 'stocktemp' => $stocktemp]);
    }


    public function SalesReturnUpload(Request $request)
    {


        StockTemp::truncate();

        Excel::import(new StockTempImport, request()->file('salesreturnfile'));


        $stock = DB::table('stock')->get();
        $stocktemp = DB::table('stocktemp')->get();



        foreach ($stocktemp as $order) {
            $stock2 = DB::table('stock')->where('description', $order->description)->first();

            DB::table('stock')->where('description', $order->description)->increment('qty', $order->qty);

            $result = DB::table('stock')
                ->where('description', $order->description)
                ->exists();
            if (!$result) {
                DB::table('stock')->insert([
                    'no' => $order->no,
                    'description' => $order->description,
                    'qty' => $order->qty,
                    'barcode' => $order->barcode
                ]);
            }
        }



        $stock = DB::table('stock')->get();


        $currentDate = Carbon::today();
        $currentTime = Carbon::now()->format('H:i:s');


        $stocktemp = DB::table('stocktemp')->get();

        foreach ($stocktemp as $order) {


            DB::table('transactionhistory')->insert([


                'trans_date' => $currentDate,
                'trans_time' => $currentTime,
                'description' => $order->description,
                'qty' => $order->qty,
                'info' => "Sales Return Data Added"
            ]);
        }

        return view("admin-dashboard/stock")->with(['stock' => $stock, 'stocktemp' => $stocktemp]);
    }


    /*
    public function StockInsert(Request $request)
    {
        $this->validate($request, [
            'instock' => 'required',
            'inbarcode' => 'required',
            'inqty' => 'required',
        ]);


        $noValue = DB::table('stock')->orderBy('no', 'desc')->value('no');

        $noValue += 1;





        DB::table('stock')->where('description', $request->instock)->increment('qty', $request->inqty);

        $result = DB::table('stock')
            ->where('description', $request->instock)
            ->exists();
        if (!$result) {
            DB::table('stock')->insert([
                'no' => $noValue,
                'description' => $request->instock,
                'qty' => $request->inqty,
                'barcode' => $request->inbarcode
            ]);
        }






        $currentDate = Carbon::today();
        $currentTime = Carbon::now()->format('H:i:s');


        DB::table('transactionhistory')->insert([


            'trans_date' => $currentDate,
            'trans_time' => $currentTime,
            'description' => $request->instock,
            'qty' => $request->inqty,
            'info' => "Stock Data Added"
        ]);
        $stock = DB::table('stock')->get();



        return view("admin-dashboard/stock")->with(['stock' => $stock]);
    }

*/

    public function AjaxInsert(Request $request)
    {
        $this->validate($request, [
            'instock' => 'required',
            'inbarcode' => 'required',
            'inqty' => 'required',
        ]);

        // $noValue = 0;
        $noValue = DB::table('stock')->orderBy('no', 'desc')->value('no');

        $noValue += 1;





        DB::table('stock')->where('description', $request->instock)->increment('qty', $request->inqty);

        $result = DB::table('stock')
            ->where('description', $request->instock)
            ->exists();
        if (!$result) {
            DB::table('stock')->insert([
                'no' => $noValue,
                'description' => $request->instock,
                'qty' => $request->inqty,
                'barcode' => $request->inbarcode
            ]);
        }

        $stock = DB::table('stock')->get();

        $currentDate = Carbon::today();
        $currentTime = Carbon::now()->format('H:i:s');


        DB::table('transactionhistory')->insert([


            'trans_date' => $currentDate,
            'trans_time' => $currentTime,
            'description' => $request->instock,
            'qty' => $request->inqty,
            'info' => "Stock Data Inserted"
        ]);

        return response()->json([
            'status' => 'success'
        ]);
        return view("admin-dashboard/stock")->with(['stock' => $stock]);
    }


    public function StockEdit($no)
    {
        $stock= Stock::where('no', '=', $no)->first();

        return view("admin-dashboard/editstock")->with(['stock' => $stock]);
        //return redirect('/');
    }

    public function StockDestroy($no)
    {
        Stock::where('no', '=', $no)->delete();


        // $stock = Stock::simplePaginate(10);
        // return view("admin-dashboard/stock")->with('stock', $stock);
        return redirect('/');
    }
}
