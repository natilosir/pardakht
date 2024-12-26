<?php

$Authority = $_GET['Authority'];
$ft = mysql_fetch_array(mysql_query("SELECT * FROM shoping WHERE trackId='$Authority'"));
$dfdn=$ft['ghay'].'0';
$ids=$ft['ids'];
$data = array("merchant_id" => "", "authority" => $Authority, "amount" => $dfdn);
$jsonData = json_encode($data);
$ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)
));

$result = curl_exec($ch);
curl_close($ch);
$result = json_decode($result, true);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    if ($result['data']['code'] == 100) {mysql_query("UPDATE shoping SET page='55' WHERE ids ='$ids'");
        $fsc=$result['data']['ref_id'];mysql_query("UPDATE shoping SET trackId='$fsc' WHERE ids ='$ids'");header("location: qf53v3c3e$ids");
    }
    if ($result['data']['code'] == 101) {
        echo '??????? ???? ??? ???? ???? ?????? ??? ?????';
    }
    if ($result['errors']['code'] == -51) {mysql_query("UPDATE shoping SET page='0' WHERE ids ='$ids'");header("location: qf53v3c3e$ids");
    } else {
        echo'code: ' . $result['errors']['code'];
        echo'message: ' .  $result['errors']['message'];
    }
}

?>
