<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $fillable = ['licenses_id'];
    protected $table = 'licenses';
    protected $primaryKey = 'licenses_id';

    function products(){
        return $this->belongsTo('App\Models\Product','products_id','products_id');
    }


}

