<?php
define("ZIBAL_MERCHANT_KEY","");
define("ZIBAL_CALLBACK_URL","");
function Zibal($path,$parameters)
{$url = 'https://gateway.zibal.ir/v1/'.$path;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($parameters));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);curl_close($ch);
return json_decode($response);}
