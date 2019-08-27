<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');
/**
 * Controller
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
    }
    
	function init($area, $controller, $action) 
	{
		$this->_name = $controller;
		$this->_action = $action; 
		
		if (!$this->view) 
		{
			$this->view = new View($this->_name, $this->_action);
						
			$this->view->set_root($area);
		}
	}

	// set view data
    function ViewData($name, $value)
    { 
        $this->view->assign($name, $value);
    }		

    // render HTML
    function Render($file = "")
    {  		
        $this->view->render($file);
    }
	
	function Title($str) {
		$this->view->title($str);
	}
	
	function Template($file) {
		$this->view->set_layout($file);
	}
}