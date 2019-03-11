<?php

function form_textbox($name, $value) {
	echo '<input type="text" name="'.$name.'" value="'.$value.'" />';
}

function form_button($name) {

}

function form_label($id, $txt) {
	echo '<label id="'.$id.'">'.$txt.'</label> ';	
}

function form_radio($name, $bool) {
	$chk = $bool ? "checked" : "";
	echo '<input type="radio" name="'.$name.'" '.$chk.' />';
}

function form_radio_group($name, $value, $list) {
	$i = 1;
	foreach($list as $key => $val) {	 
		form_radio($name, $value == $val);   
		form_label($name."_r".$i, $key);
		
		$i++;
	} 
}

function form_checkbox($name, $bool) {
	$chk = $bool ? "checked" : "";
	echo '<input type="checkbox" name="'.$name.'" '.$chk.' />';
}

function form_checkbox_group($name, $value, $list) {
	$i = 1;
	foreach($list as $key => $val) {	 
		form_checkbox($name, $value == $val);   
		form_checkbox($name."_".$i, $key);
		
		$i++;
	} 
}