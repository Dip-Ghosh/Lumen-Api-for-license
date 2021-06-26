<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\Package;
use App\Models\PackageDetail;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use App\Traits\ResponseCode;

class LicenseController extends Controller
{
use ResponseCode;

    public function index()
    {
        $license = License::all();
        if (!empty($license)) {
            return response()
                ->json([
                    'license' => $license,
                    'status' => 'success',
                    'statusCode' => '200'
                ]);
        } else {
            return response()
                ->json([
                    'license' => '',
                    'status' => 'error',
                    'statusCode' => '404'
                ]);
        }
    }



    public function find(Request $request)
    {
        $ip = $request->ip();
        if(!isset($request->products_id) && !isset($request->customers_id)){
            return response()
                ->json([
                    'message' => 'Not Found',
                    'status' => '404'
                ]);
        }else if($request->products_id == '' || $request->customers_id == ''){
            return response()
                ->json([
                    'message' => 'Not Acceptable',
                    'status' => '406'
                ]);
        }
        $license = License::where('products_id', '=', $request->products_id)
                    ->where('customers_id', '=', $request->customers_id)
                    ->with(['products'])->first();
        $data['module'] = DB::table('licenses')
            ->select('product_modules.module_code','product_modules.module_name')
            ->leftjoin('packages', 'licenses.packages_id', '=', 'packages.packages_id')
            ->leftjoin('package_details', 'packages.packages_id', '=', 'package_details.packages_id')
            ->leftjoin('product_modules', 'package_details.product_modules_id', '=', 'product_modules.product_modules_id')
            ->where('licenses.licenses_id', $license->licenses_id)
            ->get()->pluck('module_code');
        if (!empty($license)) {
            $serverIp = $license->products->server_ip;
            $fdate = $license->start_date;
            $licensePriod = $license->license_period;
            $allowAccess = $license->after_expiry_allow_days;
            $expireDate = date('Y-m-d', strtotime($fdate . " + $licensePriod days"));
            $allowAccessDate = date('Y-m-d', strtotime($expireDate . " + $allowAccess days"));
            $data['expireDate'] = $expireDate;
            $tdate = date("Y-m-d");
            $datetime1 = new DateTime($expireDate);
            $datetime2 = new DateTime($tdate);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');

            if ($ip === $serverIp) {
                if($tdate <= $expireDate){
                    if ($days <= $license->license_period) {
                        if ($days == 0) {
                            return response()
                                ->json([
                                    'data' => $data,
                                    'message' => 'Your Package will be expired today.',
                                    'status' => '205'
                                ]);
                        }
                        else if ($days > 0 && $days <= $license->notify_expiry) {
                            return response()
                                ->json([
                                    'data' => $data,
                                    'message' => $days . ' days remaining to expired',
                                    'status' => '201'
                                ]);
                        }
                        else {
                            return response()
                                ->json([
                                    'data' => $data,
                                    'message' => 'Authenticate User',
                                    'status' => '200'
                                ]);
                        }
                    }
                }else if($allowAccessDate >= date('Y-m-d')){
                    return response()
                        ->json([
                            'data' => $data,
                            'message' => 'Your License is expired. Your access will close very soon.',
                            'status' => '202'
                        ]);
                }
                else {
                    return response()
                        ->json([
                            'message' => 'License Expired',
                            'status' => '408'
                        ]);
                }
            }

            else {
                return response()
                    ->json([
                        'message' => 'IP Address Mismatch',
                        'status' => '500'
                    ]);
            }
        }
        else {
            return response()
                ->json([
                    'message' => 'Unauthorized',
                    'status' => '401'
                ]);
        }


    }

    public function store( Request $request){

        $invoice = DB::table('invoices')->where('inv_code',$request->inv_code)->first();

        $data = [
            'invoices_id'=>$invoice->invoices_id,
            'paid_amount'=>$request->amount,
            'payment_date'=>date('Y-m-d',strtotime($request->payment_date)),
            'payment_method'=>$request->payment_method,
            'payment_settlement_date'=>date('Y-m-d',strtotime($request->settlement_date)),
            'created_at'=> date("Y-m-d h:i:s"),
            'created_by'=>$invoice->customers_id,
            'status'=>1,

        ];

        if(!empty($data)){
            DB::table('payments')->insert($data);
            return response()
                ->json([
                    'data' => $data,
                    'message' => 'Data Inserted Successfully.',
                    'status' => '201'
                ]);
        }
        else{
            return response()
                ->json([
                    'data' => '',
                    'message' => 'Something Went Wrong',
                    'status' => '404'
                ]);
        }

    }

    public function searchLicenseKey(Request $request){

       $licenseKey =  DB::table('license_keys')->where('license_key',$request->license_key)->first();

        if(!empty($licenseKey)){

            $data = DB::table('licenses')->where('license_keys_id',$licenseKey->license_keys_id)->update([
                'license_key'=>$licenseKey->license_key,
                'start_date'=>$licenseKey->start_date,
                'last_renewal_date'=>$licenseKey->last_renewal_date,
                'max_user'=>$licenseKey->max_user,
                'packages_id'=>$licenseKey->packages_id,
                'license_period'=>$licenseKey->license_period
            ]);
            return response()
                ->json([
                    'data' => $data,
                    'message' => 'License Updated Successfully.',
                    'status' => '204'
                ]);
        }else{
            return response()
                ->json([
                    'message' => 'License Key mismatch',
                    'status' => '401'
                ]);
        }
    }

    /*
     *  Dip Ghosh
     *  dip.ghosh@apsissolutions.com
     *  +8801744499902
     *  find the total number of the users of the product
     *  Request $request
     *  return response json
     */
    public function totalNumberOfTheUsers(Request $request){

        if(!isset($request->products_id) && !isset($request->customers_id)){
            return response()
                ->json([
                    'message' => 'Not Found',
                    'status' => '404'
                ]);
        }
        else if($request->products_id == '' || $request->customers_id == ''){
            return response()
                ->json([
                    'message' => 'Not Acceptable',
                    'status' => '406'
                ]);
        }
        $licenseUsers =  DB::table('licenses')
                        ->where('products_id',$request->products_id)
                        ->where('customers_id',$request->customers_id)
                        ->first();
        if($licenseUsers == null){
            return response()
                ->json([
                    'message' => 'Input Mismatch.',
                    'status' => '500',
                ]);
        }else{
            $count = $licenseUsers->max_user;
            if($count != null){
                return response()
                    ->json([
                        'message' => 'Total Max user ' .$count,
                        'status' => '200',
                        'data' => $count
                    ]);
            }
            else{
                return response()
                    ->json([
                        'message' => 'Unlimited Users.',
                        'status' => '205',
                    ]);
            }
        }

    }
}
