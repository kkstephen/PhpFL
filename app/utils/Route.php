<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

function base_url()
{
	global $url_segments;
	
	$first = $url_segments[0];
	
	if (is_special($first)) {
		return '/'.$first;
	} else {
		return "";
	}		
}

function is_special($url)
{
	global $config;
	
	$special = $config['area'];
	
	return in_array($url, $special);	 
}

function url_action($controller, $act, $id = "") {
 
	return base_url()."/".$controller."/".$act.'/'.$id;
}

function redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}

function routeTo($controller, $act, $permanent = false)
{ 
	$url = url_action($controller, $act);
	 
	redirect($url, $permanent);   
}

	