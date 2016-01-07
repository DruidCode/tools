<?php
/**
 * php mcrypt扩展加解密
 *
 */

class mcrypt
{

	//cipher 算法名称 可以是MCRYPT_ 或者cast-128 gost twofish arcfour cast-256 loki97 saferplus wake blowfish-compat serpent xtea enigma rc2
	private $cipher;

	// mode 加密模式 可以是MCRYPT_MODE_ 或者cbc cfb ctr ecb ncfb nofb stream
	private $mode;

	private $code; //base64 or bin2hex

	private $_key;

	private $iv;

	public function __construct($cipher, $mode, $_key, $code='bin')
	{
		$this->cipher = $this->getCipher($cipher);
		$this->mode   = $this->getMode($mode);
		if ( empty($this->cipher) || empty($this->mode) ) {
			return false;
		}
		$this->code = $code;
		$maxSize = $this->getKeySize($this->cipher, $this->mode);
		if ( empty($maxSize) ) {
			if ( !in_array($cipher.$mode, $error) ) {
				$error[] = $cipher.$mode;
				var_dump($error);
			}
		}
		$keySize = strlen($_key);
		if ( $keySize > $maxSize) {
		//	exit('your key size = '.$keySize.' and the cipher max key size = '.$maxSize.',so exit'.chr(10));
		}
		$this->_key = $_key;
		$ivSize = $this->getIvSize($this->cipher, $this->mode);
		var_dump($ivSize);
		$this->iv = $this->createIv($ivSize);
	}

	/**
	 * 获取算法所支持最大密钥长度
	 * @param cipher
	 * @param mode
	 */
	private function getKeySize($cipher, $mode)
	{
		$len = mcrypt_get_key_size($cipher, $mode);
		return $len;
	}

	/**
	 * 获取加密模式
	 * @param mode
	 */
	private function getMode($mode)
	{
		switch($mode){
			case 'cbc':
				return MCRYPT_MODE_CBC;
			case 'cfb':
				return MCRYPT_MODE_CFB;
			case 'ecb':
				return MCRYPT_MODE_ECB;
			case 'ncfb':
				return MCRYPT_MODE_NCFB;
			case 'ofb':
				return MCRYPT_MODE_OFB;
			case 'nofb':
				return MCRYPT_MODE_NOFB;
			case 'nfb':
				return MCRYPT_MODE_NFB;
			case 'stream':
				return MCRYPT_MODE_STREAM;
			default:
				return false;
		}
	}

	/**
	 * 获取算法名称
	 * @param cipher 
	 */
	private function getCipher($cipher)
	{
		switch($cipher){
			case 'aes128':
				return MCRYPT_RIJNDAEL_128;
			case 'aes192':
				return MCRYPT_RIJNDAEL_192;
			case 'aes256':
				return MCRYPT_RIJNDAEL_256;
			case 'des':
				return MCRYPT_DES;
			case '3des':
				return MCRYPT_TRIPLEDES;
			case 'blowfish':
				return MCRYPT_BLOWFISH;
			case 'gost':
				return MCRYPT_GOST;
			default:
				return false;
		}
	}

	/**
	 * 获取初始向量大小
	 * @param cipher 
	 * @param mode 加密模式 可以是MCRYPT_MODE_ 或者cbc cfb ctr ecb ncfb nofb ofb stream
	 *
	 */
	private function getIvSize($cipher, $mode)
	{
		$size = mcrypt_get_iv_size($cipher, $mode);
		return $size;
	}

	/**
	 * 创建初始向量
	 * @param size 初始向量大小
	 * @param source 数据来源  note 在 PHP 5.6.0 之前的版本中， 此参数的默认值为 MCRYPT_DEV_RANDOM,而这在多并发下有可能阻塞
	 */
	private function createIv($size)
	{
		$iv = mcrypt_create_iv($size, MCRYPT_RAND);
		return $iv;
	}

	/**
	 * 加密
	 * @param data 需要加密的内容 如果数据长度不是 n*分组大小，则在其后使用 '\0' 补齐。
	 */
	public function encode($data)
	{
		// ecb模式 不使用初始向量
		if ( $this->mode === MCRYPT_MODE_ECB ) {
			$str = mcrypt_encrypt($this->cipher, $this->_key, $data, $this->mode);
		} else {
			$str = mcrypt_encrypt($this->cipher, $this->_key, $data, $this->mode, $this->iv);
		}
		switch($this->code) {
			case 'bin':
				$str = bin2hex($str);
				break;
			case 'base64':
				$str = base64_encode($str);
				break;
			default:
				$str = false;
				break;
		}
		return $str;
	}

	/**
	 * 解密
	 * @param data  待解密数据
	 */
	public function decode($data)
	{
		switch($this->code) {
			case 'bin':
				$data = pack('H*', $data);
				break;
			case 'base64':
				$data = base64_decode($data);
				break;
			default:
				$data = false;
				break;
		}
		if ( empty($data) ) {
			return false;
		}
		// ecb模式 不使用初始向量
		if ( $this->mode === MCRYPT_MODE_ECB ) {
			$decodeStr = mcrypt_decrypt($this->cipher, $this->_key, $data, $this->mode);
		} else {
			$decodeStr = mcrypt_decrypt($this->cipher, $this->_key, $data, $this->mode, $this->iv);
		}
		return $decodeStr;
	}
}

$cipher = array('aes128', 'aes192', 'aes256', 'des', '3des', 'blowfish', 'gost');
$mode = array('ecb', 'cbc', 'cfb', 'ofb', 'ncfb', 'nofb', 'nfb', 'stream');

//算法不支持模式列表
$no = array('aes128ncfb', 'aes128nfb', 'aes128stream', 'aes192ncfb', 'aes192nfb', 'aes192stream', 'aes256ncfb',
			'aes256nfb', 'aes256stream', 'desncfb', 'desnfb', 'desstream', '3desncfb', '3desnfb', '3desstream',
			'blowfishncfb', 'blowfishnfb', 'blowfishstream', 'gostncfb', 'gostnfb', 'goststream');

$key = 'SN~]z&V6MMKx$huYq/X&:}Ogta(bLj_C';

foreach ($cipher as $ci) {
	foreach ($mode as $mo) {
		if ( in_array($ci.$mo, $no) ) {
			continue;
		}
		$mcrypt = new mcrypt($ci, $mo, $key, 'base64');
		$s = gettimeofday(true);
		for ($i = 0; $i<1000; $i++) {
			$data = mt_rand('00000000000', '99999999999'); //11
			$encode = $mcrypt->encode($data);
		}
		$t = gettimeofday(true) - $s;
		$time[$ci][$mo] = $t;
	}
}
asort($time, SORT_NUMERIC);
var_dump($time);return;

$mcrypt = new mcrypt('aes128', 'ecb', $key, 'base64');
$encode = $mcrypt->encode('123');

var_dump($encode);
return;
$decode = $mcrypt->decode($encode);
var_dump($decode);
