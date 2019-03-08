<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');
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
			$file_view = $tmpl.$this->_controller.'/'.$this->_action . '.php';
		}
		else {
			$file_view = $tmpl.'layout/'.$file_view . '.php';
		}
      
        if (file_exists($file_view)) {
			//header
			echo $this->parse($tmpl.'layout/header.php', null);				
			
			echo $this->parse($file_view, $this->_data);	
			
			//footer
			echo $this->parse($tmpl.'layout/footer.php', null);
        } else {
            echo "Not found view template:".$this->_action;
        }
    }
	
	private function parse($filename, $data)
	{  
		//fetch object variable
		if (isset($data)) {
			extract($this->_data, EXTR_SKIP);		
		}
		
		ob_start(); 
		
		require($filename);
		
		$content = ob_get_contents();		
		
		ob_end_clean();
		
		return $content;
	}
}
