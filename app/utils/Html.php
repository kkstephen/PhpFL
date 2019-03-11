<?php 
 
function html_css($file, $ver) {
	echo html_asset('styles/'.$file.'.css?v='.$ver);
}

function html_js($file, $ver) {	 
	echo html_asset('scripts/'.$file.'.js?v='.$ver);
}

function html_img($file) {
	echo html_asset('images/'.$file);
}

function html_asset($path) {
	echo CONTENT.$path;
}
