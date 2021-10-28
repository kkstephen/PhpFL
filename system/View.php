<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');
/**
 * View Base class
 */
class View
{ 
	var $_data = array();
	var $_header = array();
	
	var $_root;
	
	var $template;
	var $tpl_header;
	var $tpl_footer;
	
    function __construct()
    { 
		$this->tpl_header = "header.php";
		$this->tpl_footer = "footer.php";
		
		$this->template = "layout";		
	    $this->_root = "";
    }
	
	//title 
	function title($str) 
	{
		$this->_header["template_title"] = $str;	
	}
	
	function set_layout($file)
	{
		$this->template .= '/'.$file;
	}

	function set_root($path)
	{		
		if ($path != "") {
			$this->_root = "area/".$path.'/';
		}
	}	
 
    // save variable
    function assign($name, $value)
    {
        $this->_data[$name] = $value;
    }
     
    // output HMTL
    function render($file_view)
    {
		$tmpl = APP_PATH.'app/'. $this->_root. 'views/';
		 	 
		$body = $tmpl. $file_view . '.php';
		
        if (file_exists($body)) {
			//header
			echo $this->find($this->tpl_header, $this->_header);				
			
			echo $this->parse($body, $this->_data);	
			
			//footer
			echo $this->find($this->tpl_footer, null);
        } else {
            exit("Not found view file.".$body);
        }
    }
	 
	function find($view, $data) {
		return $this->parse($APP_PATH.'app/views/'.$this->template.'/'.$view, $data);
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
