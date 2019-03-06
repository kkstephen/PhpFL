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
	protected $db;
	 
    public function __construct()
    { 
		$this->input = new Parser(); 
    }
    
	public function init($controller, $action) 
	{
		$this->_name = $controller;
		$this->_action = $action; 
		
		if (!$this->view) 
		{
			$this->view = new View($this->_name, $this->_action);		
		}
	}

	// set view data
    public function ViewData($name, $value)
    { 
        $this->view->assign($name, $value);
    }		

    // render HTML
    public function Render($file = "")
    {  
        $this->view->render($file);
    } 	 
}