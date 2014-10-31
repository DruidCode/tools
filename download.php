<?php
//下载文件
$file = "/home/liufang/webtest/刘方.txt";

$filename = array_pop(explode('/', $file));

header("Content-type: application/octet-stream");

//处理中文文件名
$ua = $_SERVER["HTTP_USER_AGENT"];
$encoded_filename = rawurlencode($filename);
if (preg_match("/MSIE/", $ua) or preg_match("/like Gecko/", $ua)) {  //兼容IE11 IE11 ua里面没有MSIE 但是注意360/遨游/谷歌/safari/opera都有like Gecko
header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
} else if (preg_match("/Firefox/", $ua)) {
header("Content-Disposition: attachment; filename*=\"utf8''" . $filename . '"');
} else {
header('Content-Disposition: attachment; filename="' . $filename . '"');
}

header("Content-Length: ". filesize($file));
readfile($file);
