<?php  if ( ! defined('APP_PATH')) exit('No direct script access allowed');

class CaptchaMe {
	var $api;
	var $skey;
	var $gcaptcha;	
	var $ip;
	var $response;
	
	function __construct($url = "") {	 
		$this->api = $url;
	}
	
	function verify() {
	
		$data = array(
			'secret' => $this->skey,
			'response' => $this->gcaptcha,
			'remoteip' => $this->ip              
		);		 
      
		$http = curl_init($url); 
    
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($http, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $this->api,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $data
		));

		$this->response = curl_exec($http);
		
		curl_close($http);
		
		$json = json_decode($this->response, true);
		
		return $json["success"];
    }
}
