<?php defined('APP_PATH') OR exit('No direct script access allowed');

define('CONTENT', '/assets/');

// database
$config['db']['host'] = 'sqlite:'.APP_PATH.'assets/data/event.db3';
$config['db']['username'] = '';
$config['db']['password'] = '';

$config["sskey"] = "A0A68F21340A4A589381F1B7F8681BEC";

// default controller
$config['default_controller'] = 'Home';

// lang
$config['language']	= array('default' => 'english', 'i18n' => array("zh-hk" => "chinese", "en-us" => "english")); 

// tools
$config['utils'] = array("Html", "Form", "Route", "PdoUnit");

// route
$config['route'] = array('^zh-hk' => '', '^en-us' => '');
 