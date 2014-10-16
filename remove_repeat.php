<?php
/**
 *  去掉重复
 *
 */

if(!isset($argv[1])) return;
$mobile = $argv[1];
$array = file($mobile, FILE_IGNORE_NEW_LINES);
$get_array = array_unique($array);
$f = fopen("sole.txt", "a");
foreach($get_array as $ga_value)
{
	fwrite($f,$ga_value."\r\n");
}
fclose($f);
