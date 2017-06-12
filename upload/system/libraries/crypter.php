<?php
if (!defined('FW'))
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit ();
}

class Crypter
{
	public $password = "Any password here_";
	private $algo = MCRYPT_RIJNDAEL_256;
	private $key;

	public function __construct()
	{
		$this->key = substr($this->password, 0, mcrypt_get_key_size($this->algo, MCRYPT_MODE_ECB));
	}

	public function encrypt($data)
	{
		if (!$data)
		{
			return false;
		}
		$iv_size = mcrypt_get_iv_size($this->algo, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypt = mcrypt_encrypt($this->algo, $this->key, $data, MCRYPT_MODE_ECB, $iv);
// To get URL-Safe data
		return base64_encode($crypt);
	}

	public function decrypt($data)
	{
		if (!$data)
		{
			return false;
		}
		$crypt = base64_decode($data);
		$iv_size = mcrypt_get_iv_size($this->algo, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypt = mcrypt_decrypt($this->algo, $this->key, $crypt, MCRYPT_MODE_ECB, $iv);
		return $decrypt;
	}

}
?>