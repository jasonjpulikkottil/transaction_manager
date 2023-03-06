<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchasemismatch extends Model
{
    use HasFactory;

    protected $table = 'purchasemismatch';
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

