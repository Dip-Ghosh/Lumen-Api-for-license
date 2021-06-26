<?php
namespace App\Traits;

trait ResponseCode{

    public function success()
    {
        return [
            'license' => $license,
            'status' => 'success',
            'statusCode' => '200'
        ];
    }

    public function failure()
    {
        return [
            'success' => true,
            'message' => 'Something went wrong.',
            'Status' => '401'
        ];
    }
}
