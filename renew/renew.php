<?php

$postRequest = $_POST['license_key'];

$cURLConnection = curl_init('http://localhost/plm/searchLicenseKey');
curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, ['license_key'=>$postRequest]);
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

$apiResponse = curl_exec($cURLConnection);
curl_close($cURLConnection);
$jsonArrayResponse = json_decode($apiResponse);





?>