<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;

    protected $table = 'transactionhistory';
    
    protected $primaryKey = ['trans_date', 'trans_time','description'];

    protected $fillable=[
       
        'trans_date' ,
        'trans_time',
        'transaction' ,
        'description',
        'qty',
        'info',
        
    ];
}

