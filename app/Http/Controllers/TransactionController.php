<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StockImport;
use App\Imports\StockTempImport;
use App\Exports\StockExport;
use App\Models\StockTemp;
use App\Models\Purchase;
use App\Models\Purchasemismatch;
use App\Models\TransactionHistory;
use App\Models\Scanneditems;
use DB;
use LDAP\Result;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function StockController()
    {
        $stock = Stock::orderBy('no')->simplePaginate(10);


        return view("admin-dashboard/stock")->with(['stock' => $stock]);
    }

    public function PurchaseController()
    {


        $purchase = Purchase::simplePaginate(10);

        $purchasemismatch = DB::table('purchasemismatch')->get();
        $scanneditems = DB::table('scanneditems')->get();



        return view("admin-dashboard/purchase")->with(['purchase' => $purchase, 'scanneditems' => $scanneditems, 'purchasemismatch' => $purchasemismatch]);
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

        return redirect('/');
        // return view("admin-dashboard/stock")->with(['stock' => $stock]);
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
        Purchase::truncate();
        Purchasemismatch::truncate();

        Excel::import(new StockTempImport, request()->file('purchasefile'));


        $stock = DB::table('stock')->get();
        $stocktemp = DB::table('stocktemp')->get();



        foreach ($stocktemp as $order) {

            DB::table('purchase')->insert([
                'no' => $order->no,
                'description' => $order->description,
                'qty' => $order->qty,
                'barcode' => $order->barcode,


            ]);

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



        return redirect('/purchase');
        // return view("admin-dashboard/stock")->with(['stock' => $stock, 'stocktemp' => $stocktemp]);
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
    public function AjaxEdit(Request $request)
    {
        //error_log('Some message here.');
        $this->validate($request, [
            'inno' => 'required',
            'instock' => 'required',
            'inbarcode' => 'required',
            'inqty' => 'required',
        ]);

        $stock = Stock::where('no', $request->inno)->first();
        if ($stock) {
            $stock->description = $request->instock;
            $stock->qty = $request->inqty;
            $stock->barcode = $request->inbarcode;

            $stock->save();
        }



        $stock = DB::table('stock')->get();

        $currentDate = Carbon::today();
        $currentTime = Carbon::now()->format('H:i:s');

        DB::table('transactionhistory')->insert([


            'trans_date' => $currentDate,
            'trans_time' => $currentTime,
            'description' => $request->instock,
            'qty' => $request->inqty,
            'info' => "Item Edited"
        ]);

        return response()->json([
            'status' => 'success'
        ]);
        return view("admin-dashboard/stock")->with(['stock' => $stock]);
    }

    public function AjaxDelete(Request $request)
    {
        $this->validate($request, [
            'inno' => 'required',
            'instock' => 'required',
            'inbarcode' => 'required',
            'inqty' => 'required',
        ]);
        $stock = Stock::where('no', $request->inno)->first();
        if ($stock) {
            $stock->delete();
        }


        $stock = DB::table('stock')->get();

        $currentDate = Carbon::today();
        $currentTime = Carbon::now()->format('H:i:s');

        DB::table('transactionhistory')->insert([


            'trans_date' => $currentDate,
            'trans_time' => $currentTime,
            'description' => $request->instock,
            'qty' => $request->inqty,
            'info' => "Item Deleted"
        ]);

        return response()->json([
            'status' => 'success'
        ]);
        return view("admin-dashboard/stock")->with(['stock' => $stock]);
    }

    public function AjaxCheck(Request $request)
    {
        $this->validate($request, [
            'inbarcode' => 'required',
        ]);

        $varitem = "";
        $varqty = 0;
        $inputString = $request->inbarcode;
        $numSlashes = substr_count($inputString, '/');

        if ($numSlashes >= 6) {
            $splittedString = explode('/', $inputString);
            $varitem = str_replace(' ', '', $splittedString[3]);
            $varqty = intval(ltrim(trim($splittedString[4]), '0'));
        }

        $result = DB::table('purchase')
            ->where('description', $varitem)
            ->where('qty', $varqty)
            ->exists();


        $result2 = DB::table('purchase')
            ->where('description', $varitem)
            ->where('qty', '>', $varqty)
            ->exists();

        $result3 = DB::table('purchase')
            ->where('description', $varitem)
            ->where('qty', '<', $varqty)
            ->exists();

        $result4 = DB::table('purchase')
            ->where('description', $varitem)
            ->exists();

        if ($result) {
            $row = Purchase::where('description', $varitem)->first();
            $row->delete();

            $nValue = DB::table('scanneditems')->orderBy('no', 'desc')->value('no');
            $nValue += 1;
            /*
            DB::table('scanneditems')->insert([
                'no' => $nValue,
                'description' => $varitem,
                'qty' =>  $varqty,
                'barcode' => $request->inbarcode,
                'color' => "yellow"
            ]);
*/
            $scanneditem = new Scanneditems;
            $scanneditem->no = $nValue;
            $scanneditem->description =  $varitem;
            $scanneditem->qty = $varqty;
            $scanneditem->barcode = $request->inbarcode;
            $scanneditem->color = "white";
            $scanneditem->save();
        } else if ($result2) {

            $qtypurchase = DB::table('purchase')->where('description', $varitem)->value('qty');
            $netqty =  $qtypurchase - $varqty;
            DB::table('purchase')->where('description', $varitem)->decrement('qty', $netqty);

            $nValue = DB::table('scanneditems')->orderBy('no', 'desc')->value('no');
            $nValue += 1;
            $scanneditem = new Scanneditems;
            $scanneditem->no = $nValue;
            $scanneditem->description =  $varitem;
            $scanneditem->qty = $varqty;
            $scanneditem->barcode = $request->inbarcode;
            $scanneditem->color = "red";
            $scanneditem->save();
        } else if ($result3) {
            $noValue = DB::table('purchasemismatch')->orderBy('no', 'desc')->value('no');
            $noValue += 1;

            $qtypurchase = DB::table('purchase')->where('description', $varitem)->value('qty');
            $netqty =  $varqty - $qtypurchase;
            DB::table('purchase')->where('description', $varitem)->increment('qty', $netqty);

            DB::table('purchasemismatch')->insert([
                'no' => $noValue,
                'description' => $varitem,
                'qty' =>  $netqty,
                'barcode' => $request->inbarcode,
            ]);

            $nValue = DB::table('scanneditems')->orderBy('no', 'desc')->value('no');
            $nValue += 1;
            $scanneditem = new Scanneditems;
            $scanneditem->no = $nValue;
            $scanneditem->description =  $varitem;
            $scanneditem->qty = $varqty;
            $scanneditem->barcode = $request->inbarcode;
            $scanneditem->color = "green";
            $scanneditem->save();
        } else if (!$result4) {
            $noValue = DB::table('purchasemismatch')->orderBy('no', 'desc')->value('no');
            $noValue += 1;

            DB::table('purchasemismatch')->insert([
                'no' => $noValue,
                'description' => $varitem,
                'qty' =>  $varqty,
                'barcode' => $request->inbarcode,
            ]);

            $nValue = DB::table('scanneditems')->orderBy('no', 'desc')->value('no');
            $nValue += 1;
            $scanneditem = new Scanneditems;
            $scanneditem->no = $nValue;
            $scanneditem->description =  $varitem;
            $scanneditem->qty = $varqty;
            $scanneditem->barcode = $request->inbarcode;
            $scanneditem->color = "yellow";
            $scanneditem->save();
        }

        return response()->json([
            'status' => 'success'
        ]);
    }



    public function StockDestroy($no)
    {
        Stock::where('no', '=', $no)->delete();


        // $stock = Stock::simplePaginate(10);
        // return view("admin-dashboard/stock")->with('stock', $stock);
        return redirect('/');
    }
}
