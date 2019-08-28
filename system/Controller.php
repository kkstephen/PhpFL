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
    
	function init($area, $controller, $action)
	{
		$this->_name = $controller;
		$this->_action = $action;  
		
		$this->view->set_root($area);	
	}

	// set view data
    function ViewData($name, $value)
	{ 
        $this->view->assign($name, $value);
    }

    // render HTML
    function Render($file = "")
	{
		$path = strtolower($this->_name). '/';
		
		if ($file == "") {
			$path .= strtolower($this->_action);
		} else {
			$path .= $file;
		}
		
        $this->view->render($path);
    }
	
	function Title($str)
	{
		$this->view->title($str);
	}
	
	function Template($file)
	{
		$this->view->set_layout($file);
	}
}
