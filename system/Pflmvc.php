<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

/**
 * PHP MVC Core
 * written by Stephen Yeung. (2019-2)
 */
 
defined('CORE_PATH') or define('CORE_PATH', __DIR__);

const PFL_VERSION = '1.01';

$url_segments;

class Pflmvc
{ 
    public static $Config;
	
	private $_uri; 
	private $is_debug;
	
    function __construct($config)
    {
		self::$Config = $config;
		
		$this->is_debug = $config['debug'];
    }
 
    function run()
    { 
        //$this->removeMagicQuotes();
        $this->unregisterGlobals();
		$this->loadClass(); 
        $this->setRoute();
    }
	
    // Route
    private function setRoute()
    {
		global $url_segments;
		
		$this->_uri = new Uri(self::$Config['language']);		
		
		$controllerName = self::$Config['default_controller'];
        $actionName = "index";
        $param = array();
		
		// get request uri string: 
		$url_segments = $this->_uri->get_segments($_SERVER['REQUEST_URI']);
	 
		$i = 0;
		$appPath = APP_PATH.'app/';
	
		// {area}/controller/action/id
		$area = $this->_uri->get_area();

		if (!isNULLorEmpty($area)) {
			$i++;
			
			$appPath .= "area/".$area."/";
		}			

		// {lang}/controller/action/id
		// get lang code: 
		if ($this->_uri->has_language()) {
			$i++;
		}
		
		// get controller
		if ($this->has_segment($i)) {  
			$controllerName = ucfirst($url_segments[$i]);
		}
		
		$i++;
		// get action
		if ($this->has_segment($i)) {  
			$actionName = $url_segments[$i];
		}
		
		$i++;
		// get id  
		if ($this->has_segment($i)) { 
			$param = $url_segments[$i]; 
		}

        // class file
        $controller = $appPath.'controllers/'.$controllerName.'Controller.php';
			
		if (file_exists($controller)) { 
			require $controller; 
		}
		else {			 
			if ($this->is_debug) { 
				$log = "trace on : ".$controller;
			}
		 
			exit($this->out_error());
		}
		
		// class name
		$className = $controllerName."Controller";
		 
		// create class instance
		if (method_exists($className, $actionName)) {
			$instance = new $className();
			
			$instance->init($area, $controllerName, $actionName);
			$instance->$actionName($param);
		} else {
			if ($this->is_debug) { 
				$log = "trace on : ".$className.'/'.$actionName;
			}
			
			exit($this->out_error());
		}
	}

    private function setReporting()
    {
        if (APP_DEBUG === true) {
            error_reporting(E_ALL);
            ini_set('display_errors','On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
            ini_set('log_errors', 'On');
        }
    }

    // remove symbol 
    private function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripslashes($value);
        return $value;
    }

    // check charset 
    private function removeMagicQuotes()
    {
        if (get_magic_quotes_gpc()) {
            $_GET = isset($_GET) ? $this->stripSlashesDeep($_GET ) : '';
            $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST ) : '';
            $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
            $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
        }
    }
   
    // disable register_globals  
    // http://php.net/manual/zh/faq.using.php#faq.register-globals
    private function unregisterGlobals()
    {
        if (ini_get('register_globals')) {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key => $var) {
                    if ($var === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }	
	
	private function has_segment($i) {
		global $url_segments;
		
		return count($url_segments) > $i && !isNULLorEmpty($url_segments[$i]);
	}

	public static function loadModel($className) 
	{ 
		$m = APP_PATH.'app/models/'.$className.'.php';
		
		if (file_exists($m)) { 
			require_once $m; 
		}
		
		return new $className();
	}

    // load class 
    private function loadClass()
    {
        $cls = [
            1 => CORE_PATH . '/Controller.php',
			2 => CORE_PATH . '/View.php',
			3 => CORE_PATH . '/helper/String.php',
			4 => CORE_PATH . '/helper/Uri.php',
			5 => CORE_PATH . '/helper/Parser.php',
			6 => CORE_PATH . '/db/Database.php',
			7 => CORE_PATH . '/db/Repository.php',
			8 => CORE_PATH . '/db/UnitORM.php'			
        ];
		
		foreach ($cls as $f)
		{
		    require_once $f;
		}
		
		$tools = self::$Config['utils'];
		
		$path = APP_PATH.'app/utils/';
		
		foreach ($tools as $t)
		{
			require_once $path.$t.'.php';			 
		}
    }
	
	private function out_error()
	{
		$tmpl = APP_PATH . 'app/views/layout/notfound.php';
		
		ob_start(); 
		
		require($tmpl);
		
		$content = ob_get_contents();		
		
		ob_end_clean();
		
		return $content;
	}		
}