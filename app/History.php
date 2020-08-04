<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'hd_history';
    protected $primaryKey = 'id';

    //public $incrementing = false;

    protected $fillable = [
      
    ];


    protected $hidden = [
       
    ];

    protected $keyType = 'int';
    public $timestamps = false;
}
