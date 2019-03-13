<?php  if ( ! defined('APP_PATH')) exit('No direct script access allowed');

class Session
{  
	private $expire;
	private $sskey;
	private $uid;
	
    function __construct($time, $key)
    {  
		$this->uid = "user";
        $this->expire = $time;
        $this->sskey = $key;      
    }
	
	function set_data($data) 
	{	 
		setcookie($this->uid, $data, time() + $this->expire, '/'); 
	}
	
	function get_data() 
	{
		return $_COOKIE[$this->uid];
	}
	
	function clear() 
	{
		setcookie($this->uid, "", time() - $this->expire, '/'); 
	}
}
