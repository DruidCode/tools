<?php
require('excel.php');

$filename = '导出测试';
$data = array();
$data['header'] = array('id', 'uid', 'uname');
$data['rows']   = array(
	array(1, 2, 'lilei'),
	array(2, 3, 'laowang'),
);

write($filename, $data['header'], $data['rows']);
