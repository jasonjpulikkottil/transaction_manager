<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';
    protected $keyType = 'string';
    protected $primaryKey = 'barcode';
  
    public $timestamps = false;

    protected $fillable=[
        'no',
        'description',
        'qty',
        'barcode',
        
    ];
}

