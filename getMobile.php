<?php
/**
 * @desc 生成n个随机手机号
 * @param int $num 生成的手机号数
 * @return array
 */
function randMobile($num = 1){
 //手机号2-3为数组
 $numberPlace = array(30,31,32,33,34,35,36,37,38,39,47,50,51,52,53,57,58,59,80,81,82,83,87,88,89);
 for ($i = 0; $i < $num; $i++){
  $mobile = 1;
  $mobile .= $numberPlace[rand(0,count($numberPlace)-1)];
  $mobile .= str_pad(rand(0,99999999),8,0,STR_PAD_LEFT);
  $result[] = $mobile;
 }
 return $result;
}
$result = randMobile(10);
print_r($result);
