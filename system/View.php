<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');
/**
 * 视图基类
 */
class View
{ 
	protected $_controller;
    protected $_action;
    
	var $_data = array();
	var $_header = array();
	var $tmp_header;
	var $tmpl_footer;
	
    function __construct($controller, $action)
    {
        $this->_controller = strtolower($controller);
        $this->_action = strtolower($action);
		
		$this->tmp_header = 'layout/header.php';
		$this->tmpl_footer = 'layout/footer.php';
    }
	
	//title 
	function title($str) 
	{
		$this->_header["header_title"] = $str;	
	}
 
    // save variable
    function assign($name, $value)
    {
        $this->_data[$name] = $value;
    }
     
    // output HMTL
    function render($file_view)
    {
		$tmpl = APP_PATH . 'app/views/';
		
		if ($file_view == "") {
			$file_view = $this->_action;
		}

		$body = $tmpl.$this->_controller.'/'.$file_view . '.php';
		
        if (file_exists($body)) {
			//header
			echo $this->parse($tmpl.$this->tmp_header, $this->_header);				
			
			echo $this->parse($body, $this->_data);	
			
			//footer
			echo $this->parse($tmpl.$this->tmpl_footer, null);
        } else {
            echo "Not found view template:".$file_view;
        }
    }
	
	private function parse($filename, $data)
	{  
		//fetch object variable
		if (isset($data)) {
			extract($data, EXTR_SKIP);		
		}
		
		ob_start(); 
		
		include $filename;
		
		$content = ob_get_contents();		
		
		ob_end_clean();
		
		return $content;
	}
}
