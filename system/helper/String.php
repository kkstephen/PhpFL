<?php  if ( ! defined('APP_PATH')) exit('No direct script access allowed');

function isNULLorEmpty($str) 
{
	return !isset($str) || empty($str);
}
