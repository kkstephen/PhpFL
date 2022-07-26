<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');
/**
 * Controller Base class
 */
 
class Controller
{
    protected $_name;
    protected $_action;
	
    protected $view;
	protected $input;
	protected $session;
	 
    function __construct()
    { 
		$this->input = new Parser();
		$this->view = new View();
    }
    
	function init($area, $name, $action)
	{
		$this->_name = $name;
		$this->_action = $action;  
		
		$this->view->set_root($area);	
	} 

	// set view data
    function ViewData($name, $value)
	{ 
        $this->view->set_data($name, $value);
    }
	
	function PartialVars($name, $list) {
		$this->view->set_vars($name, $list);
	}

	function Parts($name, $path) {
		$this->view->set_parts($name, $path); 
	}

    // render HTML
    function Render($file = "")
	{
		$path = strtolower($this->_name);
		
		if ($file == "") {
			$file = strtolower($this->_action);
		}  	 
		
        $this->view->render($path, $file);
    }
	
	function Title($str)
	{
		$this->view->title($str);
	}
	
	function Template($file)
	{
		$this->view->set_layout($file);
	}

	function Redirect($controller, $action, $permanent = false) 
	{
		$url = url_action($controller, $action);
	 
	    header('Location: ' . $url, true, $permanent ? 301 : 302);

        exit();
	}
	
	function Getlib($folder, $list) 
	{
		$path = APP_PATH.'app/utils/';
		
		$fp = $folder."/";
		
		foreach ($list as $name)
		{
			require_once $path.$fp.$name.'.php';			 
		}
	}
}
