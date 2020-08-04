<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'hd_favorite';
    protected $primaryKey = 'id';

    //public $incrementing = false;

    protected $fillable = [
      
    ];


    protected $hidden = [
        
    ];

    protected $keyType = 'int';
    public $timestamps = false;
}
