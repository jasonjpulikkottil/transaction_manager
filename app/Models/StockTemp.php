<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTemp extends Model
{
    use HasFactory;

    protected $table = 'stocktemp';
    
    protected $primaryKey = 'no';
    public $timestamps = false;

    protected $fillable=[
        'no',
        'description',
        'qty',
        'barcode',
    ];
}
