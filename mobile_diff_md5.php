<?php
if(!isset($argv[1])) {echo '第一个参数为md5号码,第二个参数为正常号码'."\n";return;}
if(!isset($argv[2])) {echo '第一个参数为md5号码,第二个参数为正常号码'."\n";return;}
$md5 = $argv[1];
$num = $argv[2];

$a = file_get_contents($md5);   //md5号码
$b = file($num);   //号码

$f = fopen('ok.txt',"ab");
foreach($b as $mobile) {
    $mobile = trim($mobile);
    $mobiles = md5(trim($mobile));
    $a = str_replace($mobiles, $mobile, $a);
}
fwrite($f, $a);
fclose($f);
