<?php 
if (isset($_GET['id'])){
$ids= $_GET['id'];
$daq = mysql_query("SELECT * FROM shoping WHERE ids='$ids'");
while($mta=mysql_fetch_array($daq)){
$dfdn=$mta['ghay'].'0';
$pas = array(
"merchant"=>ZIBAL_MERCHANT_KEY,
"callbackUrl"=>ZIBAL_CALLBACK_URL,
"orderId"=>$ids,
"amount"=>$dfdn,);
$rgse=Zibal('request',$pas);
};}
$c=$rgse->trackId;
$eg=$_GET['trackId'];
if($c){mysql_query("UPDATE shoping SET trackId=$c WHERE ids ='$ids'");
$r='https://gateway.zibal.ir/start/'.$rgse->trackId;
header("location: $r");
}elseif($eg){
$gas = array(
"merchant"=>ZIBAL_MERCHANT_KEY,
"trackId"=>$eg,);
Zibal('verify',$gas);
$gnse=Zibal('inquiry',$gas);
$orderId=$gnse->orderId;
$status=$gnse->status;
$trackId=$gnse->trackId;

if(($status =='1') or ($status =='2')){mysql_query("UPDATE shoping SET page='55' WHERE ids ='$orderId'");header("location: qf53v3c3e$orderId");}
if($status =='3'){mysql_query("UPDATE shoping SET page='0' WHERE ids ='$orderId'");header("location: qf53v3c3e$orderId");}
}else{header("location: index.php");}


?>