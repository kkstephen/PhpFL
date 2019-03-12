<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

function url_action($controller, $act, $id = "") {
	return "/".$controller."/".$act.'/'.$id;
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