<?php 

class Parser
{ 
	function Post($name = "")
	{ 
		return $this->cleanJs($_POST[$name]);
	}

	function PostList($name = "")
	{
		$list = array();
		
		foreach($_POST[$name] as $item) {
			array_push($list, $item);
		}

		return implode(",", $list);
	}
	 
	function Get($p = "") 
	{ 
		return $this->cleanJs($_GET[$p]);
	}

	private function cleanJs($html)
	{
		$html = trim($html);  
		$html = str_replace(array('<?','?>'),array('<?','?>'),$html);  
		
		$pattern = array(  
		   "'<script[^>]*?>.*?</script>'si",  
		   "'<style[^>]*?>.*?</style>'si",  
		   "'<frame[^>]*?>'si",  
		   "'<iframe[^>]*?>.*?</iframe>'si",  
		   "'<link[^>]*?>'si"  
	    );  
	   
	    $replace=array("","","","","");  
	   
	    return preg_replace($pattern,$replace,$html);  
	}
}
