<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');
// root dir
defined('CORE_PATH') or define('CORE_PATH', __DIR__);

/**
 * MVC Core
 */
class Pflmvc
{ 
    protected $_config = [];

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
        $controllerName = $this->_config['default'];
        $actionName = "index";
        $param = array();

        $url = $_SERVER['REQUEST_URI'];
        // fetch request url 
        $position = strpos($url, '?');
        $url = $position === false ? $url : substr($url, 0, $position);
        // del “/”
        $url = trim($url, '/');
 		
        if ($url) {
            
            $urlArray = explode('/', $url);
            // remove empty str
            $urlArray = array_filter($urlArray);
            
            // get controller name
            $controllerName = ucfirst(array_shift($urlArray));
            
            // get action name
            $actionName = $urlArray ? array_shift($urlArray) : $actionName;
            
            // get action id  
            $param = $urlArray ? array_shift($urlArray) : "";
        }

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
        $files = $this->classMap();

		foreach ($files as $file)
		{
		    include $file;
		} 
    }

    // class mapping
    protected function classMap()
    {
        return [
            1 => CORE_PATH . '/Controller.php',
			2 => CORE_PATH . '/View.php',
			3 => APP_PATH.'/app/utils/Parser.php'
        ];
    }
}