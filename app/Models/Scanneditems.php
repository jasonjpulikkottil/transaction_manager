<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scanneditems extends Model
{
    use HasFactory;

    protected $table = 'scanneditems';
    protected $keyType = 'string';
    protected $primaryKey = 'barcode';
  
    public $timestamps = false;

    protected $fillable=[
        'no',
        'description',
        'qty',
        'barcode',
        'color',
        
    ];
}

