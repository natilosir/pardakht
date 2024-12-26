<?php

$cst = $_GET['id'];
if($cst){
$ft = mysql_fetch_array(mysql_query("SELECT * FROM shoping WHERE ids='$cst' and page<'7'"));
$dfdn=$ft['ghay'].'0';
}else{header("location: /");}
$data = array("merchant_id" => "",
    "amount" => $dfdn,
    "callback_url" => "https://abinmarket.ir/gatepay/callbackzarinpal.html",
    "description" => $cst
    );
$jsonData = json_encode($data);
$ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)
));

$result = curl_exec($ch);
$err = curl_error($ch);
$result = json_decode($result, true, JSON_PRETTY_PRINT);
curl_close($ch);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    if (empty($result['errors'])) {$Fa=$result['data']["authority"];
        if ($result['data']['code'] == 100) {
if($cst){$qu =mysql_query("UPDATE shoping SET trackId='$Fa' WHERE ids ='$cst'");}
if($qu){header("location: https://www.zarinpal.com/pg/StartPay/$Fa");}
        }
    } else {
         echo'Error Code: ' . $result['errors']['code'];
         echo'<br>message: ' .  $result['errors']['message'].'<br><br>';

    }
}

?>
