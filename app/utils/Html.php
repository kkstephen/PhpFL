<?php  if ( ! defined('APP_PATH')) exit('No direct script access allowed');
 
function html_css($file, $ver) {
	echo html_asset('styles/'.$file.'.css?v='.$ver);
}

function html_js($file, $ver) {	 
	echo html_asset('scripts/'.$file.'.js?v='.$ver);
}

function html_img($file) {
	echo html_asset('images/'.$file);
}

function html_file($file) {
	echo html_asset('files/'.$file);
}

function html_asset($path) {
	echo CONTENT.$path;
}
