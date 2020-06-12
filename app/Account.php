<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'hd_account';
    protected $primaryKey = 'id';

    //public $incrementing = false;

    protected $fillable = [
       'username', 'password', 'email', 'status', 'verify_code' , 'nickname'
    ];


    protected $hidden = [
        'password',
    ];

    protected $keyType = 'int';
    public $timestamps = false;
}
