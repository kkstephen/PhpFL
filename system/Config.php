<?php

// database
$config['db']['host'] = 'mysql:host=localhost;charset=utf8;';
$config['db']['username'] = 'PPM_CPE';
$config['db']['password'] = 'PPM_pass';
$config['db']['dbname'] = 'CPE';

$config["sskey"] = "A0A68F21340A4A589381F1B7F8681BEC";

// default controller
$config['default_controller'] = 'Home';

// lang
$config['language']	= array('default' => 'english', 'i18n' => array("zh-hk" => "chinese", "en-us" => "english")); 

// tools
$config['utils'] = array("PdoUnit", "Parser");
 