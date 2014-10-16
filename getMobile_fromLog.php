<?php
/**
 * 获取日志中企信通所发送的号码
 * 关键字 'qxt mms send mobiles'
 *
 */

if(!isset($argv[1])) exit;
if(!isset($argv[2])) exit;
$filename = $argv[1];   //日志文件名
$key      = $argv[2];   //要搜索的关键字
$s = system("cat $filename | grep '$key' > infos.txt");
$files = file('infos.txt');
$f = fopen('mobile.txt', "ab");
foreach ($files as $file) {
    $file = trim($file);
    $file = preg_replace("/^(.*?)= /",'',$file);
    $nu = explode(',',trim($file));
    foreach ($nu as $n) {
        $n = trim($n); 
        fwrite($f,$n."\r\n");
    }
}
fclose($f);

//$mobiles = file('info.txt',FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
//system("cat infos.txt | awk '{print$9,$10,$11,$12}' > info.txt");
//system("cat infos.txt | awk '{for(i=9;i<13;i++){print$i}}' > info.txt");
