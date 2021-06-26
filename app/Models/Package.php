<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Package  extends Model
{
    protected $fillable = ['packages_id'];
    protected $table = 'packages';
    protected $primaryKey = 'packages_id';

    public function packageDetails()
    {
        return $this->hasMany('App\Models\PackageDetail','packages_id','packages_id');
    }
    public function packageModules()
    {
        return $this->hasManyThrough('App\Models\PackageDetail','App\Models\ProductModule','packages_id','product_modules_id');
    }

}


