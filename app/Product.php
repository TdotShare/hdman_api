<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'hd_product';
    protected $primaryKey = 'id';

    //public $incrementing = false;

    protected $fillable = [
        "id_market", "name", "price", "service", "detail"
    ];


    protected $hidden = [

    ];

    protected $keyType = 'int';
    public $timestamps = false;
}
