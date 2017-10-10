<?php

class crypt_helper
{
    private $_time; # timestamp of key creation
	private $_key; # what you wanna crypt
    private $_salt; # if you wanna decrypt
	private $_BLOWFISH;
	private $_STRING;

	function __construct(){
        $this->_BLOWFISH = '$2y$';
		$this->_time = time();
        $this->_salt = NULL;
	}

	public function get_key(){
		return $this->_key;
	}

	public function set_key($key){
		$this->_key = $key;
		return $this;
	}

	public function get_time(){
		return $this->_time;
	}

	public function set_time($time){
		$this->_time = $time;
		return $this;
	}

	public function get_salt(){
		return $this->_salt;
	}

	public function set_salt($salt){
		$this->_salt = $salt;
		return $this;
	}

	public function crypt($salt=null, $time=null, $fix='$2y$0'){
		if(is_null($time) || $time === null)
			$this->_time = time();
		else
			$this->_time = $time;
		
		$delimiter = substr(str_replace(["0", "1", "2", "3"], "", $this->_time), -1);

		if($delimiter === '' || $delimiter === null) $delimiter = '7';

		if(!isset($salt) || $salt === '' || $salt === null || is_null($salt) || func_num_args() < 1)
			$this->_salt = $this->salt();
		else
			$this->_salt = $salt;

		$crypt = crypt($this->_key, $fix.$delimiter.'$'.$this->_salt.'$');

		return array('crypt' => $crypt, 'salt' => $this->_salt, 'time' => $this->_time);
	}

	private function salt(){ # auto generate salt
		$salt = '';
		$salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
		for($i=0; $i < 22; $i++){
			$salt .= $salt_chars[array_rand($salt_chars)];
		}
		return $salt;
	}
}

?>