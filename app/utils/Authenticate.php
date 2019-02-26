<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authenticate {

    private	$_ci;
	var $key = '';
	var $user = null;
	
	public function __construct() 
	{	 		
		$this->_ci =& get_instance();
		
		$this->key = $this->_ci->config->item('encryption_key');
		$this->_ci->load->library('AES', $this->key, 'AES'); 
		
		$this->_ci->load->helper('cookie'); 			
	}	 
	
	public function sign_out() 
	{
		//set_cookie('ssid', null, -1);		
		delete_cookie('ssid');
	}
	
	public function set_identity($user, $remeber = true)
	{		
		$data = json_encode($user);		 
		
		$encrypted_str = $this->_ci->AES->encrypt($data);
		
		$domain = '';
	 	 
		set_cookie("ssid", base64_encode($encrypted_str), time()+1800); 	 			
	}
	
	public function is_authenticate()
	{ 
		$ssid = get_cookie('ssid'); 
		
		if ($ssid == "")
        {
			return false;
        }	 	
		
		try
		{		
			$this->user = $this->getIdentity($ssid);
			
			if ($this->user != null)
			{
				$domain = '';
				
				setcookie("ssid", $ssid, time()+1800, '/', $domain, false); 
				 
				return true;
			}
		}
		catch(Exception $e)
		{			
		}
				
		return false;
	}
	
	public function Identity()
	{
		return $this->user;		
	}	
	
	private function getIdentity($ssid) 
	{
		$data = base64_decode($ssid);
		
		$js = $this->_ci->AES->decrypt($data);
	  		
		return json_decode($js);	
	}
}