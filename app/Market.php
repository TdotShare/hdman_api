<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $table = 'hd_market';
    protected $primaryKey = 'id';

    //public $incrementing = false;

    protected $fillable = [
        "id_account", "name", "category", "address" , "status"
    ];


    protected $hidden = [

    ];

    protected $keyType = 'int';
    public $timestamps = false;
}
