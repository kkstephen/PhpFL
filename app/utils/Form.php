<?php  if ( ! defined('APP_PATH')) exit('No direct script access allowed');

function form_textbox($name, $value) {
	echo '<input type="text" name="'.$name.'" value="'.$value.'" />';
}

function form_button($name) {

}

function form_label($id, $txt) {
	echo '<label>'.$txt.'</label> ';	
}

function form_checkbox($name, $val, $input, $attr = "") {
	$chk = strpos($input, $val) !== false ? "checked" : "";	 
	echo '<input type="checkbox" name="'.$name.'" value="'.$val.'" '.$chk.' '.$attr.' />'; 
}

function form_checkbox_group($name, $input, $list, $attr = "") {
	$i = 1;
	
	foreach($list as $key => $val) {	 
		form_checkbox($name, $key, $input, $attr);   	
		$i++;
	} 
}

function form_radio($name, $val, $bool, $attr = "") {
	$chk = $bool ? "checked" : "";
	echo '<input type="radio" name="'.$name.'" value="'.$val.'" '.$chk.' '. $attr.' />';	
}

function form_radio_group($name, $input, $list, $attr = "") {
	$i = 1;
	
	foreach($list as $key => $val) {	 
		form_radio($name, $key, $input == $key, $attr);
		form_label($name."_r".$i, $val);
		
		$i++;
	} 
}

 