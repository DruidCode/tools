<?php
/**
 * 3des DESede/ECB/NoPadding 解密
 * 59E68A5FDE90BB54B016AE9FD7258E5D
 */


$txt = '59E68A5FDE90BB5467495BAA208CB5FD';
$result = '118804090';
$key = 'xsdzq2015';

function descrypt($data, $key)
{
	$algorithm = MCRYPT_TRIPLEDES;
	$mcryptMode = MCRYPT_MODE_ECB;
	$source = MCRYPT_RAND;
	$ivSize = mcrypt_get_iv_size($algorithm, $mcryptMode);
	$iv = mcrypt_create_iv($ivSize, $source);
	$data = pack("H*",$data);

 	$plainText = mcrypt_decrypt($algorithm, $key, $data, $mcryptMode, $iv);  
	return $plainText;
}

function encrypt($key, $data)
{
	$algorithm = MCRYPT_TRIPLEDES;
	$mcryptMode = MCRYPT_MODE_ECB;
	$source = MCRYPT_RAND;
	$ivSize = mcrypt_get_iv_size($algorithm, $mcryptMode);
	$iv = mcrypt_create_iv($ivSize, $source);

	$encryptedString = mcrypt_encrypt($algorithm, $key, $data, $mcryptMode, $iv);
	$encryptedString = bin2hex($encryptedString);
	return $encryptedString;
}

function pkcs5Pad ($text, $ivSize)
{
    $pad = $ivSize - (strlen($text) % $ivSize);
    return $text . str_repeat(chr($pad), $pad);
}

function pkcs5Unpad($text) {
    $pad = ord($text{strlen($text)-1});  
    if ($pad > strlen($text)) return false;  
    if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;  
    return substr($text, 0, -1 * $pad);  
}

function pkcs7Pad($data, $ivSize)
{
   $paddingChar = $ivSize - (strlen($data) % $ivSize);
   $data .= str_repeat(chr($paddingChar), $paddingChar);
   return $data;
}

function pkcs7Unpad($text)  
{  
    $pad = ord($text{strlen($text) - 1});  
    if ($pad > strlen($text)) {  
        return false;  
    }  
    if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {  
        return false;  
    }  
    return substr($text, 0, -1 * $pad);  
} 


$re = descrypt('59E68A5FDE90BB5467495BAA208CB5FD', $key);
var_dump($re);
return;

$result = encrypt($key, $result);
$result = strtoupper($result);
var_dump($result);return;

