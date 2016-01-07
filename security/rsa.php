<?php
/**
 * rsa 加解密
 *	openssl genrsa -out rsa_private_key.pem 1024 生成私钥
 	openssl pkcs8 -topk8 -inform PEM -in rsa_private_key.pem -outform PEM -nocrypt -out private_key.pem 转成pkcs8标准，但是php不需要
 	openssl rsa -in rsa_private_key.pem -pubout -out rsa_public_key.pem 生成公钥
 *
 *
 */

$privateKey = "
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQCx5iVmnu9P4VORp+qbTGMeWjNBKX+qWkeSSWamYH0sy7NZvIBL
W1hhu4T2PHMkNUvHIrZ0AlZHtDbSe6hbwUdCoAnw7r+LtkDaC4blorW4SfPOJF/j
S4x1igLLz3saMuugJSQW9ddcCyyBt8R6/3DVUr4Zda3PkLEA3/OLGQANnwIDAQAB
AoGBAKEqCsAJRGxtibPvF49RiIo61Sw3WD0QRL62WJRp3XzznauyJdgfDNaddztM
UFOBJQFm5Tv70gZrsS7GcCOP2elzP26eplF3KpgQ7pQR+0uuNDWo/YPdnjaRUqz8
j/AIZHef298IbrcA9qXz5sN1DXNtFUs0xATvmsWsai95tGshAkEA1h+LI5NjzEmo
T62uVCFE2P4d0VUymCQYrtT6uElubA+GKRo6fBh8fRVkKkbVtkKwLmjVsKVhm+rh
lyhS5fItfQJBANSw+UPu6SC1OiKc8zZvwk5hLH+7l0g97xAE3KqwH/PSLy4Ous7I
sHi7LORGiyymRQnNxQLeECZ7R/lWLjskwksCQDILO0S8TOXRDUJaEFVfVSz171ge
dm2yegZahqKNnv4ofq2akLKyMl41oqxy073+RhkCrXbUoESFl+XxKbbObC0CQATD
ohG/fEFbTd4QnfIONtACpTiHPzBDEuPM+BRqtYyEnMHvWoffPvS1XKAQZHWvk8RQ
c6VIzBvQjyAqqgZxIFkCQHPXe7N0+l+yxUPV/7DgnH6gHhb8FLioVEDGWZ+ht43y
9E1gt5X8+LqEA2FQJMmtoNk/9Jt3P1eTTZNUhAqVPCk=
-----END RSA PRIVATE KEY-----
";

$publicKey = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCx5iVmnu9P4VORp+qbTGMeWjNB
KX+qWkeSSWamYH0sy7NZvIBLW1hhu4T2PHMkNUvHIrZ0AlZHtDbSe6hbwUdCoAnw
7r+LtkDaC4blorW4SfPOJF/jS4x1igLLz3saMuugJSQW9ddcCyyBt8R6/3DVUr4Z
da3PkLEA3/OLGQANnwIDAQAB
-----END PUBLIC KEY-----";

$priKey = openssl_pkey_get_private($privateKey);
$pubKey = openssl_pkey_get_public($publicKey);

$s = gettimeofday(true);
for ($i=0; $i< 1000; $i++) {
$data = mt_rand('00000000000', '99999999999'); //11
//$data = "18701008325"; //11
//$data = mt_rand('0000000000000000', '9999999999999999'); //16

//公钥加密
openssl_public_encrypt($data, $encrypted, $pubKey);
//$encrypted = base64_encode($encrypted);
//var_dump($encrypted);
}
$t = gettimeofday(true) - $s;
echo $t.chr(10);
return;

//私钥解密
$encrypted = base64_decode($encrypted);
openssl_private_decrypt($encrypted, $decrypted, $privateKey);
var_dump($decrypted);
