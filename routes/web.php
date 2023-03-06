<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

Route::get('/',[TransactionController::class, 'StockController']);

Route::get('/stock',[TransactionController::class, 'StockController']);
Route::get('/sales',[TransactionController::class, 'SalesController']);
Route::get('/purchase',[TransactionController::class, 'PurchaseController']);
Route::get('/purchase-return',[TransactionController::class, 'PurchaseReturnController']);
Route::get('/sales-return',[TransactionController::class, 'SalesReturnController']);
Route::get('/transaction-history',[TransactionController::class, 'TransactionHistoryController']);

Route::post('/stock-export',[TransactionController::class, 'StockExport']);

Route::post('/stock-upload',[TransactionController::class, 'StockUpload']);
Route::post('/sales-upload',[TransactionController::class, 'SalesUpload']);
Route::post('/purchase-upload',[TransactionController::class, 'PurchaseUpload']);
Route::post('/purchasereturn-upload',[TransactionController::class, 'PurchaseReturnUpload']);
Route::post('/salesreturn-upload',[TransactionController::class, 'SalesReturnUpload']);

Route::post('/ajaxinsert',[TransactionController::class, 'AjaxInsert'])->name('ajaxinsert');
Route::post('/ajaxedit',[TransactionController::class, 'AjaxEdit'])->name('ajaxedit');
Route::post('/ajaxdelete',[TransactionController::class, 'AjaxDelete'])->name('ajaxdelete');
Route::post('/ajaxcheck',[TransactionController::class, 'AjaxCheck'])->name('ajaxcheck');


