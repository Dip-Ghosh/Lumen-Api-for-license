<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PackageDetail  extends Model
{
    protected $table = 'package_details';
    protected $primaryKey = 'package_details_id';

    function package(){
        return $this->hasOne('App\Models\Package','packages_id','packages_id');
    }
    function packageModules(){
        return $this->hasOne('App\Models\ProductModule','product_modules_id','product_modules_id');
    }
}
