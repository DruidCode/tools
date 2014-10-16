<?php
define('SMS_MOBILE_PATTERN', '/^1[3458]\d{9}$/');             //检测手机号正则
$file = file('huiyuan.txt');
$new = fopen('new.txt', "ab");
$no = fopen('no.txt', "ab");
foreach ($file as $mobile) {
    $mobile = trim($mobile);
    if (empty($mobile)) continue;
	//if (!preg_match(SMS_MOBILE_PATTERN , $mobile)) continue;
	if (!preg_match(SMS_MOBILE_PATTERN , $mobile)){
        fwrite($no, $mobile . "\r\n");
        continue;
    }
    fwrite($new, $mobile . "\r\n");
}
fclose($new);
fclose($no);
