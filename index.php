<?php
// App dir
define('APP_PATH', __DIR__ . '/');

// debug mode
define('APP_DEBUG', true);

// load core file
require(APP_PATH . 'system/Pflmvc.php');

// load config
require(APP_PATH . 'system/Config.php');

// create mvc instance
(new Pflmvc($config))->run();
