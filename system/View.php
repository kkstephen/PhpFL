<?php
/**
 * 视图基类
 */
class View
{
    protected $_data = array();
    protected $_controller;
    protected $_action;

    function __construct($controller, $action)
    {
        $this->_controller = strtolower($controller);
        $this->_action = strtolower($action);
    }
 
    // save variable
    public function assign($name, $value)
    {
        $this->_data[$name] = $value;
    }
 
    // output HMTL
    public function render()
    {      
		//fetch object variable
		extract($this->_data, EXTR_SKIP);
		
        $layout = APP_PATH . 'app/views/' . $this->_controller . '/' . $this->_action . '.php';
      
        if (file_exists($layout)) {
            include $layout;
        } else {
            echo "Not found view template:".$this->_action;
        }         
    }
}
