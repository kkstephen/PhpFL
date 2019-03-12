<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

/**
 * PHP MVC Core
 * written by Stephen Yeung. (2019-2)
 */
 
defined('CORE_PATH') or define('CORE_PATH', __DIR__);

const PFL_VERSION = '1.0';

class Pflmvc
{ 
    public static $Config;
	private $_uri; 
	
    public function __construct($config)
    {
		self::$Config = $config;
    }
 
    public function run()
    { 
        $this->removeMagicQuotes();
        $this->unregisterGlobals();
		$this->loadClass(); 
        $this->setRoute();
    }
	
    // Route
    private function setRoute()
    {
		$this->_uri = new Uri(self::$Config['language']);		
		
		$controllerName = self::$Config['default_controller'];
        $actionName = "index";
        $param = array();
		
		// get request uri string 
		$url = $_SERVER['REQUEST_URI'];		
		$this->_uri->set_uri($url);
		
		$segs = $this->_uri->segments;
		
		$i = $this->_uri->has_language() ? 1 : 0;
	 
		// get controller name
		if (!isNULLorEmpty($segs[$i])) {  
			$controllerName = ucfirst($segs[$i]);
		}
		
		$i++;
		// get action name
		if (!isNULLorEmpty($segs[$i])) {  
			$actionName = $segs[$i];
		}
		
		$i++;
		// get action id  
		if (!isNULLorEmpty($segs[$i])) {
			$param = $segs[$i];
		}

        // class file
        $controller = APP_PATH.'app/controllers/'.$controllerName.'.php';
			
		if (file_exists($controller)) { 
			require $controller; 
		}
		else {			
			exit('Page not found 404');
		} 
		
		// class name
		$className = $controllerName.'Controller';
		 
		// create class instance
		if (method_exists($className, $actionName)) {
			$instance = new $className();
			
			$instance->init($controllerName, $actionName);
			$instance->$actionName($param);
		} else {
			exit('Page not found 404');
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

    // load class 
    private function loadClass()
    {
        $cls = [
            1 => CORE_PATH . '/Controller.php',
			2 => CORE_PATH . '/View.php',
			3 => CORE_PATH . '/helper/String.php',
			4 => CORE_PATH . '/helper/Uri.php',
			5 => CORE_PATH . '/helper/Parser.php'							
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
	
	private function error_notfound()
	{
		$tmpl = APP_PATH . 'app/views/layout/notfound.php';
		
		ob_start(); 
		
		require($tmpl);
		
		$content = ob_get_contents();		
		
		ob_end_clean();
		
		return $content;
	}
}