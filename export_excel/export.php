<?php
require('excel.php');

$filename = '导出测试';
$data = array();
$data[0]['title'] = '哈哈';
$data[0]['header'] = array('id', 'uid', 'uname');
$data[0]['rows']   = array(
	array(1, 2, 'lilei'),
	array(2, 3, 'laowang'),
);
$data[1]['title'] = 'lksjdf';
$data[1]['header'] = array('id', 'uid', 'uname');
$data[1]['rows']   = array(
	array(1, 2, 'lilei123123'),
	array(2, 3, 'laowangsdfsdsdf'),
);

write($filename, $data);
