<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');
// 框架根目录
defined('CORE_PATH') or define('CORE_PATH', __DIR__);

/**
 * fastphp框架核心
 */
class Pflmvc
{
    // 配置内容
    protected $_config = [];

    public function __construct($config)
    {
        $this->_config = $config;
    }

    // 运行程序
    public function run()
    { 
        $this->removeMagicQuotes();
        $this->unregisterGlobals();
		$this->loadClass();
 
        $this->setRoute();
    }

    // 路由处理
    public function setRoute()
    {
        $controllerName = $this->_config['default'];
        $actionName = "index";
        $param = array();

        $url = $_SERVER['REQUEST_URI'];
        // 清除?之后的内容
        $position = strpos($url, '?');
        $url = $position === false ? $url : substr($url, 0, $position);
        // 删除前后的“/”
        $url = trim($url, '/');
 		
        if ($url) {
            // 使用“/”分割字符串，并保存在数组中
            $urlArray = explode('/', $url);
            // 删除空的数组元素
            $urlArray = array_filter($urlArray);
            
            // 获取控制器名
            $controllerName = ucfirst(array_shift($urlArray));
            
            // 获取动作名
            $actionName = $urlArray ? array_shift($urlArray) : $actionName;
            
            // 获取URL参数         
            $param = $urlArray ? array_shift($urlArray) : "";
        }

        // 判断控制器和操作是否存在
        $controller = APP_PATH.'app/controllers/'.$controllerName.'.php';

		if (file_exists($controller)) { 
			require $controller; 
		}
		else {
			exit('控制器不存在:'.$controller);
		} 
			
		$className = $controllerName.'Controller';
 
		if (method_exists($className, $actionName)) {					
			$instance = new $className();			
			
			$instance->init($controllerName, $actionName);
			$instance->$actionName($param);
		} else {
			exit($controllerName . '404');
		}
	}

    // 检测开发环境
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

    // 删除敏感字符
    public function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripslashes($value);
        return $value;
    }

    // 检测敏感字符并删除
    public function removeMagicQuotes()
    {
        if (get_magic_quotes_gpc()) {
            $_GET = isset($_GET) ? $this->stripSlashesDeep($_GET ) : '';
            $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST ) : '';
            $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
            $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
        }
    }

    // 检测自定义全局变量并移除。因为 register_globals 已经弃用，如果
    // 已经弃用的 register_globals 指令被设置为 on，那么局部变量也将
    // 在脚本的全局作用域中可用。 例如， $_POST['foo'] 也将以 $foo 的
    // 形式存在，这样写是不好的实现，会影响代码中的其他变量。 相关信息，
    // 参考: http://php.net/manual/zh/faq.using.php#faq.register-globals
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

    // 自动加载类
    public function loadClass()
    {
        $files = $this->classMap();

		foreach ($files as $file)
		{
		    include $file;
		} 
    }

    // 内核文件命名空间映射关系
    protected function classMap()
    {
        return [
            1 => CORE_PATH . '/Controller.php',
			2 => CORE_PATH . '/View.php',
			3 => APP_PATH.'/app/utils/Parser.php'
        ];
    }
}