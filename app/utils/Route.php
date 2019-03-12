<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

function url_action($controller, $act, $id = "") {
	echo "/".$controller."/".$act.'/'.$id;
}

function redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}
