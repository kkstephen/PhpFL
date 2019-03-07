<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');

/**
 * PHP MVC Core
 * written by Stephen Yeung. (2019-2)
 */
 
defined('CORE_PATH') or define('CORE_PATH', __DIR__);

const PL_VERSION = '1.0';

class Pflmvc
{ 
    protected $_config = [];
	private $_uri; 
	
    public function __construct($config)
    {
        $this->_config = $config;
    }
 
    public function run()
    { 
        $this->removeMagicQuotes();
        $this->unregisterGlobals();
		$this->loadClass(); 
        $this->setRoute();
    }

    // Route
    public function setRoute()
    {
        $actionName = "index";
        $param = array();
		
		// get request uri string 
		$url = $_SERVER['REQUEST_URI'];		
		$this->_uri->set_uri($url);
		
		$segs = $this->_uri->segments;
		
		$i = $this->_uri->has_language() ? 0 : 1;
		     
		// get controller name
		$controllerName = isset($segs[$i]) ? $segs[$i++] : $this->_config['default'];
		
		// get action name
		$actionName = isset($segs[$i]) ? $segs[$i++] : "index";
		
		// get action id  
		$param = isset($segs[$i]) ? $segs[$i] : "";       

        // class file
        $controller = APP_PATH.'app/controllers/'.$controllerName.'.php';

		if (file_exists($controller)) { 
			require $controller; 
		}
		else {
			exit('File miss:'.$controller);
		} 
		
		// class name
		$className = $controllerName.'Controller';
 
		// create class instance
		if (method_exists($className, $actionName)) {					
			$instance = new $className();			
			
			$instance->init($controllerName, $actionName);
			$instance->$actionName($param);
		} else {
			exit($controllerName . '404');
		}
	}

    public function setReporting()
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
    public function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripslashes($value);
        return $value;
    }

    // check charset 
    public function removeMagicQuotes()
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
    public function unregisterGlobals()
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
    public function loadClass()
    {
        $this->coreClass();

		$this->_uri = new Uri($this->_config);
		
    }

    // class mapping
    protected function coreClass()
    {
        $c = [
            1 => CORE_PATH . '/Controller.php',
			2 => CORE_PATH . '/View.php',
			3 => CORE_PATH . '/Uri.php'					
        ];
		
		foreach ($c as $f)
		{
		    require_once $f;
		}
		
		$tools = $this->_config['utils'];
		
		foreach ($tools as $t)
		{
		    require_once $t;
		}
    }
}