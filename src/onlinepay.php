<?php
@session_start();define('news_security',true);if((!isset($_GET['id']))){header("location: ../index.php");exit();}
include("../includes/config.php");
include("../includes/template.php");
include("../includes/function.php");
include("../includes/jdf.php");
include("../includes/cal.php");
include("../includes/poll.php");
$A=rand(999,9999);$dater = time();
$ip = @$_SERVER['REMOTE_ADDR'];
$htp = coco();
$qaq = @$_SESSION['u_id'];if ($qaq == "")$qaq = rand(999,9999);
@ifban($ip);
rashref();
$MyTpl = new Template();
$Theme ='cdgfdfcdsx.htm';
$MyTpl -> load_file($Theme);
include("../includes/page.php");
include("../includes/count.php");
include("../includes/sovar.php");
$today = jdate("l d M 13y");
$MyTpl -> assign( array(
'fullurl'=> "$_SERVER[REQUEST_URI]",
'sitetitle' => $config['sitetitle'],
'downupsite' => $config['downupsite'],
'sitedescription' => $config['sitedes'],
'siteurl' => $config['site'],
'RashCMS' => 1,
'sitekeywords' => $config['sitekey']
));
include('../includes/mainblock.php');
$ctimestamp = jmaketime (jdate('H'), 0, 0, jdate('m'),jdate('d'),jdate('Y'));
if (isset($_GET['id'])) {
$id= $_GET['id'];
$dataq = mysql_query("SELECT * FROM shoping WHERE ids='$id' and page<'5' and user = '$qaq' LIMIT 1");
if (mysql_num_rows($dataq) <= 0){header("location: /404.html"); die();}
$mdata = mysql_fetch_array($dataq);
$ids = $mdata['ids'];
$as = $mdata['adress'];
$fhgf = $mdata['ghay'];
$q = mysql_fetch_array(mysql_query("SELECT * FROM address WHERE u_id='$as' LIMIT 1"));
$name = $q['name'];
$mobile = $q['mobile'];
$ostan = $q['ostan'];
$shahr = $q['shahr'];
$mahale = $q['mahale'];
$adr = $q['adr'];
$sfx = mysql_fetch_array(mysql_query("SELECT COUNT(*) as num FROM shopid WHERE shoping ='$ids'"));
$rfs = $sfx['num'];
$MyTpl -> add_block('sfy',array(
'ids'=> $ids,
'name'=> $name,
'adr'=> $adr,
'mahale'=> $mahale,
'shahr'=> $shahr,
'ostan'=> $ostan,
'cou'=> num($rfs),
'mobile'=> num($mobile),
'fhgf'=> num(number_format($fhgf)),
));}




$dataq = mysql_query("SELECT * FROM sitob ORDER BY u_id DESC");
while ($mdata = mysql_fetch_array($dataq)) {
$sitob = $mdata['sitob'];
$href = $mdata['href'];
$title = $mdata['title'];
$MyTpl -> add_block('sitob',array(
'sitob'=> $sitob,
'href'=> $href,
'title'=> $title,
));}
$dataq = mysql_query("SELECT * FROM topsite ORDER BY u_id DESC");
while ($mdata = mysql_fetch_array($dataq)) {
$topsite = $mdata['topsite'];
$href = $mdata['href'];
$title = $mdata['title'];
$MyTpl -> add_block('topsite',array(
'topsite'=> $topsite,
'href'=> $href,
'title'=> $title,
));}
$dataq = mysql_query("SELECT * FROM downsite ORDER BY u_id DESC");
while ($mdata = mysql_fetch_array($dataq)) {
$downsite = $mdata['downsite'];
$href = $mdata['href'];
$title = $mdata['title'];
$MyTpl -> add_block('downsite',array(
'downsite'=> $downsite,
'href'=> $href,
'title'=> $title,
));}
$dataq = mysql_query("SELECT * FROM comments ORDER BY c_id DESC LIMIT 6");
while ($mdata = mysql_fetch_array($dataq)) {
$c_author = $mdata['c_author'];
$p_id = $mdata['p_id'];
$text = $mdata['text'];
$MyTpl -> add_block('allcom',array(
'c_author'=> $c_author,
'id'=> $p_id,
'text'=> $text,
));}
$bnfq = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT page) as num FROM history WHERE user ='$qaq' or http ='$htp' limit 8"));
$gfra = $bnfq['num'];
if ($gfra > 7){$MyTpl -> add_block('avr',array());
$ataq = mysql_query("SELECT DISTINCT page FROM history WHERE user ='$qaq' or http ='$htp' ORDER BY rand() DESC");
while ($tsta = mysql_fetch_array($ataq)) {
$sdd = $tsta['page'];
$qb = mysql_fetch_array(mysql_query("SELECT * FROM data WHERE id=$sdd limit 1"));
$icup = $qb['picup'];
$title = $qb['title'];
$MyTpl -> add_block('lqm',array(
'sdd'=> $sdd,
'icup'=> "/image/225/".$icup,
'title'=> $title,));}}
$t232 = mysql_fetch_array(mysql_query("SELECT COUNT(*) as num FROM sabad WHERE ok ='1' and (user ='' and (ip ='$ip' or http ='$htp'))"));
$w23m = $t232['num'];
if ($w23m > 0){$MyTpl -> add_block('ukw',array());}
if ($w23m == 0){$MyTpl -> add_block('tyw',array());}
$dataq = mysql_query("SELECT * FROM picup WHERE pageid='$id' ORDER BY id DESC LIMIT 5");
while ($mdata = mysql_fetch_array($dataq)) {
$pic = $mdata['pic'];
$MyTpl -> add_block('dse', array('pic' => "/image/70/".$pic,));}
$dataq = mysql_query("SELECT * FROM picup WHERE pageid='$id' ORDER BY id DESC");
while ($mdata = mysql_fetch_array($dataq)) {
$pic = $mdata['pic'];
$MyTpl -> add_block('wfe', array('pic'=> "/image/2017/".$pic,'pzic'=> "/image/150/".$pic,));}
$comm = mysql_query("SELECT * FROM comments WHERE p_id='$id' ORDER BY c_id DESC LIMIT 50");
while ($cs = mysql_fetch_array($comm)){
$MyTpl -> add_block('comment',array(
'poauthor' => $cs['c_author'],
'id' => $cs['c_id'],
'text' => nl2br(smile($cs['text'])),
'podate' => mytime($config['dtype'],$cs['date'],$config['tzone']),
'url' => $cs['url'],
'ip' => $cs['ip'],
'num' => $cs['num'],
'nmum' => $cs['nmum'],
));}
$mosd = mysql_fetch_array(mysql_query("SELECT COUNT(*) as num FROM ghayhis WHERE shop ='$id'"));
$mo = $mosd['num'];
if ($mo > 0){$MyTpl -> add_block('npq',array());
$dataq = mysql_query("SELECT * FROM ghayhis WHERE shop ='$id' ORDER BY date desc limit 99");
while ($mdata = mysql_fetch_array($dataq)) {
$dsar = $mdata['user'];
$q = mysql_fetch_array(mysql_query("SELECT * FROM admin WHERE id=$dsar limit 1"));
$ids = $q['company'];
$de = $mdata['date'];
$wara = $mdata['wara'];
$waran = $mdata['waran'];
$ghay = num(number_format($mdata['ghay']));
$qwe = $mdata['discount'];
$asd = $mdata['ghay'];
$waran = $mdata['waran'];
$dids = num(number_format($mdata['discount']));
if(!empty($qwe)){
$MyTpl -> assign('yod',1);
$MyTpl -> add_block('syr',array(
'date'=> num(mytime($config['dtype'],$de,$config['tzone'])),
'wara'=> $wara." ".$waran,
'dis'=> num(round(100-($qwe/$asd)*100,0)),
'ghay'=> $ghay,
'display'=> "style='display:none'",
'discount'=> $dids,
'ids'=> $ids,
));}elseif(empty($qwe)){
$MyTpl -> assign('goo',1);
$MyTpl -> add_block('syr',array(
'date'=> num(mytime($config['dtype'],$de,$config['tzone'])),
'wara'=> $wara." ".$waran,
'dplay'=> "style='display:none'",
'price'=> $ghay,
'ids'=> $ids,
));
}}}else{$MyTpl -> add_block('nfv',array());}
$bof = mysql_fetch_array(mysql_query("SELECT COUNT(*) as num FROM ghay WHERE shop ='$id'"));
$bgf = $bof['num'];
$bdf = mysql_fetch_array(mysql_query("SELECT COUNT(*) as num FROM ghay WHERE shop ='$id' and kala > '0'"));
$bvf = $bdf['num'];
if ($bgf == 0){$MyTpl -> add_block('bbz',array());}
elseif ($bvf == 0){$MyTpl -> add_block('nmg',array());}
else{


$agr = mysql_query("SELECT * FROM ghay WHERE shop ='$id' and kala > '0' ORDER BY seting asc limit 1");
while ($tfta = mysql_fetch_array($agr)) {
$setting = $tfta['seting'];
if ($setting == 1){$MyTpl -> add_block('bam',array());}
elseif ($setting == 2){$MyTpl -> add_block('bbz',array());}
elseif ($setting == 3){$MyTpl -> add_block('nmg',array());}
elseif ($setting == 4){$MyTpl -> add_block('tgt',array());}else{

$ataq = mysql_query("SELECT * FROM ghay WHERE shop ='$id' and kala > '0' and seting = '0' ORDER BY date desc limit 1");
while ($tdta = mysql_fetch_array($ataq)) {
$dids = num(number_format($tdta['discount']));
$ghay = num(number_format($tdta['ghay']));
if(!empty($dids)){$MyTpl -> add_block('tzi',array('ghay'=> $ghay,'discount'=> $dids,));}
if(empty($dids)){$MyTpl -> add_block('lkq',array('ghay'=> $ghay,));}
$sent = $tdta['sent'];
if($sent < "50"){$MyTpl -> assign('osm',1);if($sent == "1"){$MyTpl -> assign('aqq',1);}if($sent == "2"){$MyTpl -> assign('aqw',1);}
if($sent == "3"){$MyTpl -> assign('aqe',1);}if($sent == "4"){$MyTpl -> assign('aqr',1);}if($sent == "5"){$MyTpl -> assign('aqt',1);}
if($sent == "6"){$MyTpl -> assign('aqy',1);}if($sent == "7"){$MyTpl -> assign('aqu',1);}if($sent == "8"){$MyTpl -> assign('aqi',1);}
if($sent == "9"){$MyTpl -> assign('aqo',1);}if($sent == "10"){$MyTpl -> assign('aqp',1);}}else{$MyTpl -> assign('qsa',1);}
$waran = $tdta['waran'];
$wara = $tdta['wara'];
$shid = $tdta['id'];
$gzb = $tdta['user'];
$qwe = $tdta['discount'];
$asd = $tdta['ghay'];
$qb = mysql_fetch_array(mysql_query("SELECT * FROM admin WHERE id=$gzb"));
$seller = $qb['company'];
$incode = $qb['incode'];
$de = $qb['date'];
$imt = num($qb['imt']);
$re = num($qb['rezayat']);
$ar = num($qb['arsal']);
$ba = num($qb['bazgasht']);
$bfx = mysql_fetch_array(mysql_query("SELECT COUNT(*) as num FROM ghay WHERE user ='1' and shop ='$id' and kala > '0'"));
$brs = $bfx['num'];
if ($brs > 0){
$ataq = mysql_query("SELECT * FROM ghay WHERE user ='1' and shop ='$id' and kala > '0' ORDER BY ghay aSC limit 1");
while ($tdta = mysql_fetch_array($ataq)) {
$MyTpl -> add_block('bfo',array(
'wara'=> $wara." ".$waran,
'sent'=> $sent,
'shid'=> $shid,
'dis'=> num(round(100-($qwe/$asd)*100,0)),
));}}else{
$bax = mysql_fetch_array(mysql_query("SELECT COUNT(*) as num FROM ghay WHERE user !='1' and shop ='$id' and kala > '0'"));
$bkx = $bax['num'];
if ($bkx > 0){

$ataq = mysql_query("SELECT * FROM ghay WHERE user !='1' and shop ='$id' and kala > '0' ORDER BY ghay aSC limit 1");
while ($tdta = mysql_fetch_array($ataq)) {

$MyTpl -> add_block('bgh',array(
'wara'=> $wara." ".$waran,
'seller'=> $seller,
'date'=> num(mytime($config['dtype'],$de,$config['tzone'])),
'dis'=> num(round(100-($qwe/$asd)*100,0)),
'imt'=> $imt,
'shid'=> $shid,
'incode'=> $incode,
'rezayat'=> $re,
'arsal'=> $ar,
'bazgasht'=> $ba,
));}}}}}}}
$ataq = mysql_query("SELECT * FROM shop ORDER BY rand() DESC");
while ($tdta = mysql_fetch_array($ataq)) {
$picup = $tdta['picup'];
$idd = $tdta['id'];
$title = $tdta['title'];
$ghay = num(number_format($tdta['ghay']));
$MyTpl -> add_block('tose',array(
'icup'=> "/image/225/".$picup,
'sdd'=> $idd,
'title'=> $title,
'hay'=> $ghay,
));}
$dataq = mysql_query("SELECT * FROM data WHERE date <= '$ctimestamp' And id='$id' ORDER BY id DESC LIMIT 1");
$mdata = mysql_fetch_array($dataq);
$tvote= $mdata['tvote'];
$code = $mdata['code'];
$description = $mdata['description'];
$keywords = $mdata['keywords'];
$MyTpl -> add_block('title',array(
'tvote'=> $tvote,
'code'=> "shop-".$code.".html",
'description'=> $description,
'keywords'=> $keywords,
));


$MyTpl -> assign('qazaq',$_SESSION['u_id']);
$MyTpl -> assign('name',$_SESSION['name']);
$MyTpl -> assign('lasnam',$_SESSION['lasnam']);
$MyTpl -> assign('auto','');
$MyTpl -> assign('Page',1);
$MyTpl -> assign('pages',$pagination);
$MyTpl -> assign('pagess',$pagess);
$MyTpl -> assign('calendar',$Cal);
$MyTpl -> assign('footer',$footer);
$MyTpl -> print_template();
?>