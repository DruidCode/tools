<?php
/*	
	@FileName:id.php
	@Des:身份证随机产生，身份证校验
	@Aurthor: OneDou [http://oneodu.com]
	@LastModifed:2013-1-23 下午3:55:44
	@Charset:UTF-8
	@行政区划分代码，国家统计局地址 http://www.stats.gov.cn/tjsj/tjbz/xzqhdm/
*/
$content = '';
//产生身份证的数量
$total_ids_showed = 1000;
//身份证起止年月 eg：1990年12月31日  mktime(0,0,0,12,31,1990)
$Year_start = mktime(0,0,0,1,1,1950);
$Year_end = mktime(0,0,0,12,31,2000);

//全国区域代码 共3131
$file = file('xingzheng_201504.txt');
foreach ($file as $row) {
	$row = trim($row);
	$xzq = substr($row, 0, 6);
	$Region[] = $xzq;
}
 
function calc_suffix_d ($base){
	if (strlen($base) <> 17){
		die('Invalid Length');
	}
	$factor = array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
	$sums = 0;
	for ($i=0;$i< 17;$i++){
 
		$sums += substr($base,$i,1) * $factor[$i];
	}
 
	$mods = $sums % 11;//10X98765432
 
	switch ($mods){
		case 0:  return '1';break;
		case 1:  return '0';break;
		case 2:  return 'X';break; //大写
		case 3:  return '9';break;
		case 4:  return '8';break;
		case 5:  return '7';break;
		case 6:  return '6';break;
		case 7:  return '5';break;
		case 8:  return '4';break;
		case 9:  return '3';break;
		case 10: return '2';break;
 
	}
 
}
 
for($i=0;$i< $total_ids_showed;$i++){
 
$seed = mt_rand( 0,count($Region)-1 );//total of region code
$Birth = mt_rand($Year_start,$Year_end);
$Birth_format = date('Ymd',$Birth);
$suffix_a = mt_rand(0,9);
$suffix_b = mt_rand(0,9);
$suffix_c = mt_rand(0,9);//male or female
$base = $Region[$seed].$Birth_format.$suffix_a.$suffix_b.$suffix_c;
 
$content .=  $base.calc_suffix_d($base)."\n";
}
 
//echo $content;//屏幕输出
file_put_contents('ids.txt', $content);//将所有ID写入当前目录hi.txt中
//echo calc_suffix_d('37083019681106379');//根据身份证前17位计算最后校验位
