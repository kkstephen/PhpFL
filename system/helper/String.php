<?php  if ( ! defined('APP_PATH')) exit('No direct script access allowed');

function isNULLorEmpty($str) 
{
	return !isset($str) || empty($str);
}

function startWith($str, $query) {
	return substr($str, 0, strlen($query)) === $query;
}