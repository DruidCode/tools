<?php
if(!isset($argv[1])) return;
if(!isset($argv[2])) return;
$file = $argv[1];
$file1 = $argv[2];

$mem = file($file);
$not = file($file1);
$mem1 = array();
$not1 = array();
foreach($mem as $me) {
	$me = trim($me);
	$mem1[] = $me;
}
foreach($not as $no) {
    $no = trim($no);
	$not1[] = $no;
}

$f   = fopen('new.txt', "ab");
$re = array_diff($not1,$mem1); //在$argv[2]里，但是不在$argv[1]里
//$re = array_intersect($mem1,$not1); //交集
//var_dump($re);
foreach ($re as $r) {
    $r = trim($r);
    fwrite($f, $r."\n");
}
fclose($f);

/*$same = '';
$same = explode(',', $same);
$mem = file('members.txt');
$all = array();
$f   = fopen('differnt.txt', 'ab');
foreach($mem as $mem1){
    $mem1 = trim($mem1);
	$all[]=$mem1;
}
$re = array_diff($all, $same);
var_dump($re);
$string = implode(',', $re);
fwrite($f,$string);
fclose($f);
*/
