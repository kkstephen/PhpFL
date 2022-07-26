<?php if ( ! defined('APP_PATH')) exit('No direct script access allowed');
/**
 * View Base class
 */
class View
{ 
	var $_data = array(); 
	
	var $_partial = array();
	var $_body = array();
	
	var $_root;	
	var $_folder;
	var $template;  
	
	var $is_gzip = false;
	
    function __construct()
    {  
		$this->template = "layout";
	    $this->_root = "";
    }
	
	//title 
	function title($str) 
	{
		$this->_data["header"]["template_title"] = $str;	
	}
	
	function meta($str) {
		$this->_data["header"]["meta_desc"] = $str;	
	}
	
	function set_layout($file)
	{
		$this->template .= '/'.$file;
	}
	
    function get_tpl() {
		return APP_PATH.'app/views/'.$this->template;
	}
	
	function set_root($path)
	{		
		if ($path != "") {
			$this->_root = "area/".$path.'/';
		}
	}	
	
	function set_parts($name, $file) 
	{
		$this->_partial["tpl"][$name] = $file; 
	}
 
	function set_vars($name, $datas) 
	{
		$this->_partial["vars"][$name] = $datas; 
	}
	
    // set variable
    function set_data($name, $value)
    {
        $this->_data["body"][$name] = $value;
    }
      
    // output HMTL
    function render($folder, $file_view)
    {
		$tmpl = APP_PATH.'app/'. $this->_root. 'views/';
		 	 
		$body = $tmpl. $folder . "/". $file_view . '.php';
		
        if (!file_exists($body)) { 
			$body = $this->get_tpl(). "/" . $file_view . '.php';
		}
		
		if (file_exists($body)) { 
		
			//header
			echo $this->parse($this->get_tpl()."/header.php", $this->_data["header"]); 
			
			foreach ($this->_partial["tpl"] as $name => $tpl) {
				$html = $this->parse($this->get_tpl()."/".$tpl, $this->_partial["vars"][$name]);  
				
				$this->set_data($name, $html); 
			}
						
			echo $this->parse($body, $this->_data['body']); 
			
			//footer 
			echo $this->parse($this->get_tpl()."/footer.php", null); 
			
        } else {
            exit($this->parse($tmpl.'layout/'.'error.php', null));
        }
    }
 
	private function parse($filename, $data)
	{   
		ob_start();  
		
		//fetch object variable
		if (isset($data)) {				 
			extract($data, EXTR_SKIP);		
		}
		
		include $filename;
		
		$content = ob_get_contents();		
		
		ob_end_clean();
		
		return $content;
	}  
}
