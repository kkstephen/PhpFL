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
    public function render($file_view)
    {
		$tmpl = APP_PATH . 'app/views/';
		
		if ($file_view == "") {
			$tmpl .= $this->_controller.'/'.$this->_action . '.php';
		}
		else {
			$tmpl .= 'layout/'.$file_view . '.php';
		}
      
        if (file_exists($tmpl)) {
			echo $this->parse($tmpl);	
        } else {
            echo "Not found view template:".$this->_action;
        }
    }
	
	private parse($filename)
	{
		ob_start();
	 
		//fetch object variable
		extract($this->_data, EXTR_SKIP);
		
		include $filename;
		
		$content = ob_get_contents();		
		ob_end_clean();
		
		return $content;
	}
}
