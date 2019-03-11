<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');
/**
 * 视图基类
 */
class View
{
    protected $_data = array();
    protected $_controller;
    protected $_action;
	
	public $header;
	public $footer;

    function __construct($controller, $action)
    {
        $this->_controller = strtolower($controller);
        $this->_action = strtolower($action);
		
		$this->header = 'layout/header';
		$this->footer = 'layout/footer';
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
			$file_view = $this->_action;
		}

		$body = $tmpl.$this->_controller.'/'.$file_view . '.php';
		
        if (file_exists($body)) {
			//header
			echo $this->parse($tmpl.$this->header.'.php', null);				
			
			echo $this->parse($body, $this->_data);	
			
			//footer
			echo $this->parse($tmpl.$this->footer.'.php', null);
        } else {
            echo "Not found view template:".$file_view;
        }
    }
	
	private function parse($filename, $data)
	{  
		//fetch object variable
		if (isset($data)) {
			extract($this->_data, EXTR_SKIP);		
		}
		
		ob_start(); 
		
		include $filename;
		
		$content = ob_get_contents();		
		
		ob_end_clean();
		
		return $content;
	}
}
